<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_Catalog
 * @copyright
 * @author
 */
class USWF_Catalog_Helper_Data extends Mage_Core_Helper_Abstract
{

    /**
     * Returns well-formated product compatible list
     * @param Mage_Catalog_Model_Product $product
     * 
     * @return array
     */
    public function getProductCompatibleList($product) {
        $result = array();
        if ($product->getCompatible()) {
            $manufacturerIds = explode('|', $product->getCompatible());
            $manufacturerIds = array_map('trim', $manufacturerIds);
            $collection = Mage::getModel('catalog/product')->getCollection();
            $collection->addAttributeToSelect(array('brand_actual_value', 'manufacturer_id'));
            $collection->addAttributeToFilter('manufacturer_id', array('IN' => $manufacturerIds));
            $collection->getSelect()->group('e.manufacturer_id');
            $collection->getSelect()->group('e.brand_actual_value');
            foreach ($collection as $item) {
                if (!isset($result[$item->getBrandActualValue()])) {
                    $result[$item->getBrandActualValue()] = array(
                        array(
                            'brand' => $item->getBrandActualValue()
                        )
                    );
                    $result[$item->getBrandActualValue()][] = array(
                        'part' => $item->getManufacturerId()
                    );
                } else {
                    $result[$item->getBrandActualValue()][] = array(
                        'part' => $item->getManufacturerId()
                    );
                }
            }
            ksort($result);
            $result = count($result) ? call_user_func_array('array_merge', $result) : $result;
        }
        return $result;
    }

    /**
     * Returns well-formated product compatible list
     * 
     * @param int $qty
     * @param int $span
     * 
     * @return string
     */
    public function getFilterLabelHtml($qty, $span = true) {
        $qty = $qty*1;
        if ($span) {
            return $this->__(
                '<span class="qty">%s&nbsp;%s</span>',
                $qty, 
                $qty > 1 ? $this->__('Filters') : $this->__('Filter')
            );
        } else {
            return $this->__(
                '%s %s',
                $qty,
                $qty > 1 ? $this->__('Filters') : $this->__('Filter')
            );
        }
    }

}
