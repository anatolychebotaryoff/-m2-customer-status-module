<?php
/**
 * Media.php
 *
 * @category    USWF
 * @package     USWF_ImageZoom
 * @copyright
 * @author
 */
class USWF_ImageZoom_Block_Product_View_Media extends Mage_Catalog_Block_Product_View_Media
{
    
    protected $childGalleryImages = null;
    
    /**
     * Retrieve list of gallery images
     *
     * @return array|Varien_Data_Collection
     */
    public function getChildGalleryImages()
    {
        if ($this->childGalleryImages == null) {
            $this->childGalleryImages = array();
            $product = $this->getProduct();
            if ($product->getTypeId() == Mage_Catalog_Model_Product_Type_Grouped::TYPE_CODE) {
                $groupedChildren = $product->getTypeInstance(true)
                    ->setStoreFilter($product->getStore(), $product)
                    ->getAssociatedProducts($product);
                foreach ($groupedChildren as $product) {
                    $this->childGalleryImages[] = new Varien_Object(array(
                        'file' => $product->getImage() ?
                            $product->getImage() : 
                            Mage::getResourceModel('catalog/product')->getAttributeRawValue(
                                $product->getEntityId(), 'image', Mage::app()->getStore()
                            ),
                        'label' => $this->getImageLabel($product),
                        'id' => 'package-qty-' . $product->getPackageQty()
                    ));
                }
            }
        }
        return $this->childGalleryImages;
    }
}