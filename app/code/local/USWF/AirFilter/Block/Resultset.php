<?php
/**
 * Resultset.php
 *
 * @category    USWF
 * @package     USWF_AirFilter
 * @copyright
 * @author
 */
class USWF_AirFilter_Block_Resultset extends Lyonscg_AirFilter_Block_Resultset
{
    protected $preparedProducts = array();

    /**
     * preparing product collection with given attributes and taking the first one
     *
     * @param $catId
     * @param $mervSuffix
     * @param $sizeAttrValue
     * @return bool
     */
    public function prepareProduct($catId, $mervSuffix, $sizeAttrValue)
    {
        $hash = md5($catId . $mervSuffix . $sizeAttrValue);
        if (!isset($this->preparedProducts[$hash])) {
            $_sizeAttrCode = Mage::getStoreConfig('lyonscg_airfilter/air_filter_details/dfs_size_attr_code');
            $_category = Mage::getModel('catalog/category')->load($catId);
            $_productCollection = $_category->getProductCollection();
            $_productCollection->addAttributeToFilter($_sizeAttrCode,
                array('eq' => Mage::getResourceModel('catalog/product')
                    ->getAttribute($_sizeAttrCode)
                    ->getSource()
                    ->getOptionId($sizeAttrValue)))
                ->addAttributeToFilter('mpr',
                    array('eq' =>
                        Mage::getResourceModel('catalog/product')
                            ->getAttribute('mpr')
                            ->getSource()
                            ->getOptionId("MPR:".$mervSuffix)));
            if(Mage::getResourceModel('catalog/product')
                ->getAttribute('air_filter_finder')){
                $_productCollection->addAttributeToFilter('air_filter_finder',
                    array('eq' =>
                        Mage::getResourceModel('catalog/product')
                            ->getAttribute('air_filter_finder')
                            ->getSource()
                            ->getOptionId("Yes")));
            }
            $_productCollection->setVisibility(Mage::getSingleton('catalog/product_visibility')
                ->getVisibleInCatalogIds())
                ->addAttributeToSelect('merv_value')
                ->load();
            $_products = $_productCollection->getItems();
            if($_products && is_array($_products)){
                $_firstProduct = array_shift($_products);
                $_product = Mage::getModel('catalog/product')->load($_firstProduct->getEntityId());
                $this->preparedProducts[$hash] = $_product;
            } else {
                $this->preparedProducts[$hash] = false;
            }
        }
        return $this->preparedProducts[$hash];
    }

    /**
     * taking admin options labels of particular mpr attribute
     *
     * @param $key
     * @return array
     */
    public function getMervAdminLabel($key){
        $result = parent::getMervAdminLabel($key);
        array_splice($result, 1, 0, array(array('label' => 'MERV Rating' , 'position' => 1)));
        return $result;
    }

    /**
     * taking store options of particular mpr attribute
     *
     * @param $key
     * @param $_product
     * @return mixed
     */
    public function getMervOptionsByIdProduct($key, &$_product){
        $result = $this->getMervOptionsById($key);
        if(is_null($_product)){
            array_splice($result, 1, 0, array(array('label' => 'checkbox[no]' , 'value' => -1)));
        } else {
            $attribute = $_product->getResource()->getAttribute('merv')->getSource()->getOptionText($_product->getMerv());
            $attribute = str_replace(':', ' ', $attribute);
            array_splice($result, 1, 0, array(array('label' => "text[$attribute]" , 'value' => -1)));
            $_product = null;
        }
        return $result;
    }

}