<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     USWF_CMS
 * @copyright
 * @author
 */
class USWF_CMS_Model_Observer
{
    /**
     * Add breadcrumbs data to admin cms page form
     *
     * @param Varien_Event_Observer $observer
     * @return USWF_CMS_Model_Observer
     */
    public function addBreadcrumbsData(Varien_Event_Observer $observer) {
        $form = $observer->getEvent()->getForm();
        if ($layoutFildset = $form->getElement('layout_fieldset')) {
            $layoutFildset->addField(
                'show_cms_breadcrumbs', 
                'select', 
                array(
                    'name'      => 'show_cms_breadcrumbs',
                    'label'     => Mage::helper('uswf_cms')->__('Show Breadcrumbs'),
                    'values'    => Mage::getModel('uswf_cms/system_config_source_breadcrumbs')->getAllOptions()
                ),
                'root_template'
            );
        }
        return $this;
    }

    public function cmsPageRender(Varien_Event_Observer $observer) {
        $page = $observer->getEvent()->getPage();
        if ($page->getRootTemplate() == 'uswf_ro') {
            $product = Mage::getModel('catalog/product')->loadByAttribute('sku', $page->getRoProductSku());
            if ($product) {
                $action = $observer->getEvent()->getControllerAction();

                // Prepare data
                $productHelper = Mage::helper('catalog/product');
                $_product = $productHelper->initProduct($product->getId(), $action);
                $design = Mage::getSingleton('catalog/design');
                $settings = $design->getDesignSettings($_product);
                if ($settings->getCustomDesign()) {
                    $design->applyCustomDesign($settings->getCustomDesign());
                }
                $update = $action->getLayout()->getUpdate();
                $update->removeHandle('ro_page');
                $update->addHandle('catalog_product_view');
                $update->addHandle('PRODUCT_TYPE_' . $_product->getTypeId());
                $update->addHandle('PRODUCT_' . $_product->getId());
                $update->addHandle('ro_page');
            }
        }
    }

}