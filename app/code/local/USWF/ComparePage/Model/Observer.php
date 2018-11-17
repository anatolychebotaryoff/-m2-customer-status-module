<?php

class USWF_ComparePage_Model_Observer extends Varien_Object
{

    public function catalogProductDeleteAfterDone(Varien_Event_Observer $observer) {
        $productId = $observer->getProduct()->getId();
        $comparePage = Mage::getModel('uswf_comparepage/compare_widget')->loadByProductId($productId, 0);
        $comparePage->delete();
    }

    public function catalogProductPrepareSave(Varien_Event_Observer $observer)
    {
        $event = $observer->getEvent();
        $request = $event->getRequest();
        $_product = $event->getProduct();
        $storeId = (int)Mage::app()->getRequest()->getParam('store');
        /** @var USWF_ComparePage_Model_Compare_Widget $comparePage */
        $comparePage = Mage::getModel('uswf_comparepage/compare_widget')->loadByProductId($_product->getId(), $storeId);
        $comparePageData = $request->getPost('comparepage');

        //remove compare page
        if (!$comparePage->isEmpty() && $storeId == Mage_Catalog_Model_Abstract::DEFAULT_STORE_ID
            && $comparePageData['is_create_compare_page'] == 0) {
            $comparePage->delete();
            //remove link
            $comparePage->addData(array('compared_products' => $comparePageData['compared_products']));
            $compareData = Mage::helper('adminhtml/js')->decodeGridSerializedInput($comparePageData['compared_products']);
            Mage::getResourceSingleton('catalog/product_link')->saveProductLinks($_product, $compareData, USWF_ComparePage_Model_Compare_Widget::LINK_TYPE_COMPARE);
            Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('uswf_comparepage')->__('Compare Page has been deleted'));
            return;
        }

        //check duplicate of page_identifier
        if (!isset($comparePageData['page_identifier']) || $comparePageData['page_identifier'] == "") {
            $comparePageData['page_identifier'] = 'compare/' . $_product->getSku() . '-tier1.html';
        }

        if (isset($comparePageData['page_identifier']) && $comparePageData['page_identifier']) {
            $comparePageDuplicate = Mage::getModel('uswf_comparepage/compare_widget')->loadByPageIdentifier($comparePageData['page_identifier'], $storeId);
            if (!$comparePageDuplicate->isEmpty() && $comparePageDuplicate->getPageIsActive() && $comparePageDuplicate->getId() != $comparePage->getId()) {
                Mage::getSingleton('adminhtml/session')->addError(Mage::helper('uswf_comparepage')->__('Compare Page invalid save: %s', 'URL Key must be unique(duplicate product id:'.$comparePageDuplicate->getParentProductId().')'));
                return;
            }
        }

        $comparePage->addData(array('compared_products' => $comparePageData['compared_products']));
        $compareData = Mage::helper('adminhtml/js')->decodeGridSerializedInput($comparePageData['compared_products']);

        //sort by store id
        $resultWebId = array();
        foreach ($compareData as $key => $item) {
            $wId = explode(',',$item['compared_website_id']);
            foreach ($wId as $_item) {
                $_pos = (int)$item['compared_position'];
                $resultWebId[$_item][$_pos][$key] =  $item;
            }
        }
        if (isset($resultWebId[$storeId]) && count($resultWebId[$storeId]) > 3) {
            Mage::getSingleton('adminhtml/session')->addError(Mage::helper('uswf_comparepage')->__('Compare Page invalid save: %s', 'a limit of 3 items that can be added to this list'));
            return;
        }

        foreach ($resultWebId as $store => $item) {
            foreach ($item as $_pos => $_item) {
                if ($_pos < 2 || $_pos > 4){
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('uswf_comparepage')->__('Compare Page invalid save: %s', 'position must be (> 2 or < 4)'));
                    return;
                }
                if ($_pos == 0) {
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('uswf_comparepage')->__('Compare Page invalid save: %s', 'position must be'));
                    return;
                }
                if (count($_item) > 1) {
                    Mage::getSingleton('adminhtml/session')->addError(Mage::helper('uswf_comparepage')->__('Compare Page invalid save: %s', 'Position ' . $_pos . ' for store id ' . $store . ' more than one'));
                    return;
                }
            }
        }

        Mage::getResourceSingleton('catalog/product_link')->saveProductLinks($_product, $compareData, USWF_ComparePage_Model_Compare_Widget::LINK_TYPE_COMPARE);

        if ($storeId) {
            $widgetStore = $comparePage->getWidgetStore();
            $widgetStore->addData($comparePageData);
            $widgetStore->addData(array('website_id' => $storeId, 'parent_product_id' => $_product->getId()));

            $comparePageDataDefault = $request->getPost('comparepage_use_default');
            if (is_array($comparePageDataDefault)) {
                $comparePageDataDefault = array_map(array($this,"changedCheckbox"), $comparePageDataDefault);
            }
            $widgetDefault = $comparePage->getWidgetDefault();
            //check the default column
            $result = USWF_ComparePage_Helper_Data::$COMPARE_WIDGET_DEFAULT_COLUMN;
            $option = USWF_ComparePage_Helper_Data::$COMPARE_PRODUCTS_OPTIONS;
            foreach ($option as $pos) {
                foreach (USWF_ComparePage_Helper_Data::$compareWidgetDefaultColumnOption as $colName) {
                    $result[$colName . $pos] = 0;
                }
            }
            $diff = array_diff_key($result, $comparePageDataDefault);
            $widgetDefault->addData($comparePageDataDefault);
            $widgetDefault->addData($diff);
            $widgetDefault->addData(array('website_id' => $storeId, 'parent_product_id' => $_product->getId()));

        } else {
            $pageId = strtolower($comparePageData['page_identifier']);
            $comparePageData = $request->getPost('comparepage');
            $comparePageData['page_identifier'] = $pageId;
            $comparePage->addData($comparePageData);
            $comparePage->addData(array('website_id' => $storeId, 'parent_product_id' => $_product->getId()));
        }

        try{
            //if the page_identifier does not exist (create page) or adding of the store
            $pageIdentifier = $comparePage->getData('page_identifier');
            if ($pageIdentifier) {
                $cmsPage = Mage::getModel('cms/page')->load($pageIdentifier, 'identifier');
                $checkPage = $cmsPage->checkIdentifier($pageIdentifier, $storeId);
                if ($cmsPage->isEmpty()) {
                    $cmsPage
                        ->setStoreId(array($storeId))
                        ->setTitle($comparePage->getData('page_title'))
                        ->setIdentifier($pageIdentifier)
                        ->setRootTemplate('one_column');
                } else if (!$checkPage) {
                    $stores = $cmsPage->getStoreId();
                    $stores[] = $storeId;
                    $cmsPage->setStoreId($stores);
                }
                $cmsPage->setIsActive($comparePage->getData('page_is_active'));
                $cmsPage->save();
            }

            $comparePage->save();
        } catch (Exception $ex) {
            Mage::logException($ex);
            Mage::getSingleton('adminhtml/session')->addError($ex->getMessage());
        }

    }

    public function changedCheckbox($element){
        if ($element == 'on') {
            return 1;
        }
        return 0;
    }

    public function cmsPageRender(Varien_Event_Observer $observer) {

        /* Check URL for /compare - only need to run on these pages */
        $currentUrl = Mage::helper('core/url')->getCurrentUrl();
        $url = Mage::getSingleton('core/url')->parseUrl($currentUrl);
        $path = $url->getPath();
        if (strpos($path, "/compare") === FALSE) {
            return;
        }
        Varien_Profiler::start('USWF_Compare_LOAD');

        $page = $observer->getPage();
        $identifier = $page->getIdentifier();
        /** @var USWF_ComparePage_Model_Compare_Widget $comparePage */
        $comparePage = Mage::getModel('uswf_comparepage/compare_widget')->loadByPageIdentifier($identifier, Mage::app()->getStore()->getId());
        if (!$comparePage->isEmpty()) {
            if ($comparePage->getPageIsActive()) {
                $page->setMetaRobots($comparePage->getData('page_meta_robots'));
                $content = is_null($page->getContent()) ? '' : $page->getContent();
                $content = $content.' {{widget tier1_position="0" type="uswf_comparedto/product_widget_link" template="catalog/product/widget/compare_new.phtml" }}';
                $page->setContent($content);
                $page->setTitle($comparePage->getPageTitle());
                $page->setExcludeFromSitemap($comparePage->getData('page_exclude_from_sitemap'));
                $comparePage->setWebsiteId(Mage::app()->getStore()->getId());
                Mage::register('compare_page',$comparePage);
            }
        }

        Varien_Profiler::stop('USWF_Compare_LOAD');

    }

    public function adminhtmlCmsPageEditTabContentPrepareForm(Varien_Event_Observer $observer) {
        $model = Mage::registry('cms_page');
        $identifier = $model->getIdentifier();
        foreach ($model->getStoreId() as $store) {
            $comparePage = Mage::getModel('uswf_comparepage/compare_widget')->loadByPageIdentifier($identifier, $store);
            if (!$comparePage->isEmpty() && $comparePage->getPageIdentifier() == $identifier) {
                $url = Mage::helper('adminhtml')->getUrl('adminhtml/catalog_product/edit',
                    array(
                        'id' => $comparePage->getParentProductId(),
                        'store' => $store,
                        'active_tab' => 'comparepage'
                    )
                );
                $form = $observer->getForm();
                $fieldset = $form->getElement('content_fieldset');
                $fieldset->addField('compare_page_product_link', 'link', array(
                    'name'      => 'compare_page_product_link',
                    'label'     => Mage::helper('cms')->__('Compare Page'),
                    'title'     => Mage::helper('cms')->__('Compare Page'),
                    'value'     => 'Link to Product',
                    'href'      => $url,
                ),'content_heading');
                return;
            }
        }
    }

}
