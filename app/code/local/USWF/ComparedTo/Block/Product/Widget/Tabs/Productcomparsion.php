<?php
/**
 * Productcomparsion.php
 *
 * @category    USWF
 * @package     USWF_ComparedTo
 * @copyright
 * @author
 */
class USWF_ComparedTo_Block_Product_Widget_Tabs_Productcomparsion extends Mage_Core_Block_Template
{
    const ADDITIONAL_INFORMATION_ATTRIBUTE = 'addl_information';


    protected function _prepareLayout() {
        $this->setTemplate('catalog/product/widget/compare/tabs/product_comparsion.phtml');
        $this->setLabel('Product Comparison');
        return parent::_prepareLayout();
    }

    /**
     * Returns content of tab table
     *
     * @return array($header, $body)
     */
    public function getContent() {
        $header =  array(
            'tier1' => $this->getWidget()->getData('label1'),
            'oem' => $this->getWidget()->getData('label2')
        );
        $header = !$this->getWidget()->getData('tier1_position') ? $header : array_reverse($header);

        $products = $this->getWidget()->getProducts();
        if (!empty($products)) {
            $lowestPrices = array();
            $manufacturer = array();
            foreach ($products as $product) {
                $lowestPrices[] = $product->getExtLowestPrice() ? $this->__('As Low As %s per filter with %s pack',
                    $this->helper('core')->currency($product->getExtLowestPrice()), $product->getExtPkgQty() * 1) : '';
                $manufacturer[] = $product->getManufacturerId();
            }

            $body = array();

            if (in_array(self::ADDITIONAL_INFORMATION_ATTRIBUTE,
              $this->getWidget()->getAttributes())) {

              $addl_information = $this->getAttributeFromProduct($products,
                self::ADDITIONAL_INFORMATION_ATTRIBUTE);
              if ($addl_information)
                $body[] = $addl_information;

            }

            $body[] = array('label' => 'Price Per Filter', 'content' => $lowestPrices);
            $body[] = array('label' => 'Model', 'content' => $manufacturer);

            foreach ($this->getWidget()->getAttributes() as $attribute) {

                if ($attribute == self::ADDITIONAL_INFORMATION_ATTRIBUTE) continue;

                $attr = $this->getAttributeFromProduct($products,
                  $attribute);
                if ($attr)
                  $body[] = $attr;

                /*$attributeObject = $this->getAttribute($attribute);
                if ($attributeObject->getId()) {
                    $values = array();
                    foreach ($products as $product) {
                        $values[] = ($value = $product->getAttributeText($attribute)) ?
                            $this->convertToString($value) : $this->convertToString($product->getData($attribute));
                    }
                    $body[] = array('label' => $attributeObject->getStoreLabel(), 'content' => $values);
                }*/
                
            }
            for ($i = 1; $i <= 5; $i++) {
                $userDefinedText = $this->helper('core')->stripTags(
                    $this->getWidget()->getData('user_defined' . $i . '_text')
                );
                $userDefinedLowCost = $this->getWidget()->getData('user_defined' . $i . '_low_cost');
                $userDefinedLowCost = (strpos($userDefinedLowCost, 'wysiwyg') === 0) ?
                    '<img src="' . Mage::getBaseUrl('media') . $userDefinedLowCost . '" />' :
                    $this->helper('core')->stripTags($userDefinedLowCost);
                $userDefinedOem = $this->getWidget()->getData('user_defined' . $i . '_oem');
                $userDefinedOem = (strpos($userDefinedOem, 'wysiwyg') === 0) ?
                    '<img src="' . Mage::getBaseUrl('media') . $userDefinedOem . '" />' :
                    $this->helper('core')->stripTags($userDefinedOem);
                if (!empty($userDefinedText) || !empty($userDefinedLowCost) || !empty($userDefinedOem)) {
                    $body[] = array(
                        'label' => $userDefinedText,
                        'content' => !$this->getWidget()->getData('tier1_position') ?
                            array($userDefinedLowCost, $userDefinedOem) : array($userDefinedOem, $userDefinedLowCost)
                    );
                }
            }
        }
        return array($header, $body);
    }

    /**
     * Load attribute by code to used on frontend
     *
     * @param $attributeName
     *
     * @return Mage_Eav_Model_Entity_Attribute_Abstract
     * @throws Mage_Core_Exception
     */
    protected function getAttribute($attributeName)
    {
        $attribute = Mage::getModel('eav/entity_attribute')->loadByCode(Mage_Catalog_Model_Product::ENTITY, $attributeName);
        return $attribute;
    }

    /**
     * Convert value to string
     *
     * @param string $value
     * @return string
     */
    protected function convertToString($value) {
        return is_array($value) ? implode(', ', $value) : $value;
    }


    protected function getAttributeFromProduct($products, $attribute) {

      $attributeObject = $this->getAttribute($attribute);
      if ($attributeObject->getId()) {
          $values = array();
          foreach ($products as $product) {
              $values[] = ($value = $product->getAttributeText($attribute)) ?
                  $this->convertToString($value) : $this->convertToString($product->getData($attribute));
          }
          return  array('label' => $attributeObject->getStoreLabel(), 'content' => $values);
      }

      return false;

    }

}
