<?php

class USWF_BrontoTrack_IndexController extends Mage_Core_Controller_Front_Action
{
    public function indexAction()
    {
        $this->getResponse()->clearHeaders()->setHeader(
            'Content-type',
            'application/json'
        );

        $rawOutputData = $this->getTracking();
        $outputData = array();

        $count = 1;
        foreach ($rawOutputData as $d) {

            $item = "item_".$count."_";

            if ($d['item_fulfils_subscription'] || $d['parent_item']) continue;

            $expDate = new DateTime($d["created_at"]);
            $d['subscription_interval'] = $d['subscription_interval'] ? preg_match('(\d+)', $d['subscription_interval']) : 0; 
            $expDate->add( new DateInterval('P'. ( $d["qty_ordered"] * $d['subscription_interval'] ) .'M' ));

            $outputData[] = array(
                $item . "order_number" => $d["increment_id"],
                $item . "order_date" => $d["created_at"],
                $item . "sku" => $d["sku"], 
                $item . "quantity" => $d["qty_ordered"],
                $item . "type" => $d["attribute_set_name"],
                $item . "expiration_date" => $expDate->format('Y-m-d H:i:s'),
                $item . "oem_type" => $d["oem_aftermarket_private"],
                $item . "snowflake_url" => $d["snowflake_url"] ? $d["snowflake_url"] : $d["url_key"],
                $item . "segment" => $d["snowflake_url"] ? "Compare" : "", 
            ); 

            $count++;
        }
        

        // Set the response body / contents to be the JSON data
        $this->getResponse()->setBody(
            Mage::helper('core')->jsonEncode( $outputData )
        );
    }

    private function getTracking()
    {

        $customer_email = $this->getRequest()->getParam("email"); 
        $store = Mage::app()->getStore()->getId();
        $snowflake_id = Mage::getModel('eav/config')->getAttribute('catalog_product', 'snowflake_url')->getId();
 
        $collection = Mage::getResourceModel('sales/order_item_collection')
            ->addAttributeToSelect('*');
        $collection->getSelect()->join( array('orders'=> 'sales_flat_order'),
            'orders.entity_id=main_table.order_id',array('orders.customer_email','orders.increment_id','orders.created_at'));

        $collection->getSelect()->join( array('products'=> 'catalog_product_flat_'.$store),
            'products.entity_id=main_table.product_id',array('products.attribute_set_id', 'products.url_key', 'products.url_path', 'products.oem_aftermarket_private'));
      
        $collection->getSelect()->joinLeft( array('snowflake' => 'catalog_product_entity_varchar'),
            'snowflake.entity_id=main_table.product_id AND attribute_id='.$snowflake_id.' AND snowflake.store_id='.$store, array('snowflake_url'=>'snowflake.value'));
 
        $collection->getSelect()->join( array('attributeset'=> 'eav_attribute_set'),
            'attributeset.attribute_set_id=products.attribute_set_id',array('attributeset.attribute_set_name'));

        $collection->addFieldToFilter('orders.customer_email', $customer_email);
        $collection->addFieldToFilter('orders.store_id', $store);

        $collection->setOrder('orders.created_at', 'desc');
        $collection->setPageSize(10);

        return $collection->getData();

    }

}
