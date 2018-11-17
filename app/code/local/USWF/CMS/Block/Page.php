<?php
/**
 * Page.php
 *
 * @category    USWF
 * @package     USWF_CMS
 * @copyright
 * @author
 */

class USWF_CMS_Block_Page extends MageWorx_SeoBase_Block_Cms_Page {

    /**
     * Prepare global layout
     *
     * @return Mage_Cms_Block_Page
     */
    protected function _prepareLayout()
    {
        $page = $this->getPage();

        // show breadcrumbs
        if (
            (($page->getShowCmsBreadcrumbs() == USWF_CMS_Model_System_Config_Source_Breadcrumbs::SHOW) || 
             (($page->getShowCmsBreadcrumbs() == USWF_CMS_Model_System_Config_Source_Breadcrumbs::USE_STORE_DEFAULT) &&
                Mage::getStoreConfig('web/default/show_cms_breadcrumbs')))
            && ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs'))
            && ($page->getIdentifier()!==Mage::getStoreConfig('web/default/cms_home_page'))
            && ($page->getIdentifier()!==Mage::getStoreConfig('web/default/cms_no_route'))
        ) {
            $breadcrumbs->addCrumb('home', array(
                'label'=>Mage::helper('cms')->__('Home'),
                'title'=>Mage::helper('cms')->__('Go to Home Page'),
                'link'=>Mage::getBaseUrl())
            );
            $breadcrumbs->addCrumb('cms_page', array(
                'label'=>$page->getTitle(),
                'title'=>$page->getTitle())
            );
        }

        $root = $this->getLayout()->getBlock('root');
        if ($root) {
            $root->addBodyClass('cms-'.$page->getIdentifier());
        }

        $head = $this->getLayout()->getBlock('head');
        if ($head) {
            $head->setTitle($page->getTitle());
            $head->setKeywords($page->getMetaKeywords());
            $head->setDescription($page->getMetaDescription());
        }

        $page = $this->getPage();
        if ($head = $this->getLayout()->getBlock('head')) {
            $head->setRobots($page->getMetaRobots());
        }

        return $this;
    }
}