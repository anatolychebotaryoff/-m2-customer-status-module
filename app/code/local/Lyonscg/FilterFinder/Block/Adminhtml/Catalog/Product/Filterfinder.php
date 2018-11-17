<?php
/**
 * This class creates a new tab under Catalog -> Manage Products when you either
 * create a new product or edit an existing product with Filter Finder attributes.
 *
 * @category    Lyonscg
 * @package     Lyonscg_FilterFinder
 * @copyright   Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author      Ashutosh Potdar (apotdar@lyonscg.com)
 */

/**
 * Filterfinder Class for the "New Filter Finder" Tab.
 *
 * @category Lyons
 * @package  Lyonscg_FilterFinder
 */
class Lyonscg_FilterFinder_Block_Adminhtml_Catalog_Product_Filterfinder
    extends Mage_Adminhtml_Block_Widget_Form
implements Mage_Adminhtml_Block_Widget_Tab_Interface
{
    /**
     * Set the template for the block
     *
     */
    public function _construct()
    {
        parent::_construct();

        $this->setTemplate('filterfinder/filterfinder.phtml');
    }

    /**
     * Retrieve the label used for the tab relating to this block
     *
     * @return string
     */
    public function getTabLabel()
    {
        return $this->__('New Filter Finder');
    }

    /**
     * Retrieve the title used by this tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return $this->__('New Filter Finder');
    }

    /**
     * Determines whether to display the tab
     * Add logic here to decide whether you want the tab to display.
     *
     * @return bool
     */
    public function canShowTab()
    {
        // The tab is only displayed for other stores and not default store.
        if( ! Mage::app()->getRequest()->getParam('store') ) {
            return false;
        }
        return true;
    }

    /**
     * Stops the tab being hidden
     *
     * @return bool
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Show group prices grid website column
     *
     * @return bool
     */
    public function isShowWebsiteColumn()
    {
        if ($this->isScopeGlobal() || Mage::app()->isSingleStoreMode()) {
            return false;
        }
        return true;
    }

    /**
     * Check is allow change website value for combination
     *
     * @return bool
     */
    public function isAllowChangeWebsite()
    {
        if (!$this->isShowWebsiteColumn() || $this->getProduct()->getStoreId()) {
            return false;
        }
        return true;
    }

    /**
     * Retrieve the product Id
     *
     * @return Mage_Catalog_Model_Product $product
     */
    public function getProductId()
    {
        $product = Mage::registry('product');
        return $product->getId();
    }

    /**
     * Retrieve the website Id which the admin store is switched to.
     * 
     * @return integer
     */
    public function getWebsiteId()
    {
        return Mage::app()->getRequest()->getParam('store');
    }

    /**
     * This modules retrives data based on product id and website id.
     *
     * @return array
     */
    public function filterfinderData() {
        $filterFinderData = array();
        $productId = $this->getProductId();
        $websiteId = $this->getWebsiteId();

        $collection = Mage::getResourceModel('lyonscg_filterfinder/filterfinder_collection');
        $collection->addFieldToFilter('product_entity_id', array('eq' => $productId));
        $collection->addFieldToFilter('website_id', array('eq' => $websiteId));

        // Check if there are any records in the collection.
        $filterFinderData = $collection->getData();

        if (!empty($hasData)) {
            return $filterFinderData;
        }

        return $filterFinderData;
    }

    /**
     * Prepare global layout
     * Add "Add Filter Finder" button to layout
     *
     * @return Lyonscg_FilterFinder_Block_Adminhtml_Catalog_Product_Filterfinder
     */
    protected function _prepareLayout()
    {
        $button = $this->getLayout()->createBlock('adminhtml/widget_button')
            ->setData(array(
                'label' => Mage::helper('lyonscg_filterfinder')
                        ->__('Add Filter Finder'),
                'onclick' => 'return filterFinderControl.addItem()',
                'class' => 'add'
            ));
        $button->setName('add_filterfinder_item_button');

        $this->setChild('add_button', $button);
        return parent::_prepareLayout();
    }

    /**
     * Retrieve 'add filterfinder item' button HTML
     *
     * @return string
     */
    public function getAddButtonHtml()
    {
        return $this->getChildHtml('add_button');
    }

    /**
     * This method returns all the Brands along with their ids and labels.
     *
     * @return array
     */
    protected function getAllBrands() {
        return $this->getAttributeIdLabel('filter_finder_brand');
    }

    /**
     * This method returns all the Styles along with their ids and labels.
     *
     * @return array
     */
    protected function getAllStyles() {
        return $this->getAttributeIdLabel('filter_finder_style');
    }

    /**
     * This method returns all the Locations along with their ids and labels.
     *
     * @return array
     */
    protected function getAllLocations() {
        return $this->getAttributeIdLabel('filter_finder_location');
    }

    /**
     * This method returns all the Removals along with their ids and labels.
     *
     * @return array
     */
    protected function getAllRemovals() {
        return $this->getAttributeIdLabel('filter_finder_removal');
    }

    /**
     * This function returns all the attribute options for given filter finder attribute.
     *
     * @return array
     */
    public function getAttributeIdLabel($givenAttributeId)
    {
        // Get all the attributes from filter_finder_style
        $attributeId = Mage::getResourceModel('eav/entity_attribute')
                ->getIdByCode('catalog_product', $givenAttributeId);
        $attributeObj = Mage::getModel('catalog/resource_eav_attribute')
                ->load($attributeId);
        return $attributeObj->getSource()->getAllOptions();
    }
}
