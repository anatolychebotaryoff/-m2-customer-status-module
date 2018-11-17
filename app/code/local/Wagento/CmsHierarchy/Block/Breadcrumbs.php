<?php
class Wagento_CmsHierarchy_Block_Breadcrumbs extends Mage_Page_Block_Html_Breadcrumbs
{
    /**
     * Gets the breadcrumbs based off of the CMS hierarchy included in EE
     *
     * @return array
     */
    public function getCmsBreadcrumbs()
    {

        $crumbs = array();

        // #1
        $crumbs['home'] = array(
            'label' => Mage::helper('cms')->__('Home'),
            'title' => Mage::helper('cms')->__('Go to Home Page'),
            'link' => Mage::getBaseUrl(),
        );

        // #2
        $hierarchyModel = Mage::getSingleton('enterprise_cms/hierarchy_node');
        $collection = $hierarchyModel
            ->getCollection()
            ->addFieldToFilter('page_id', $this->getHelper('cms/page')->getPage()->getPageId())
        ;

        // First get the current CMS page's hierarchy
        // #3
        foreach ($collection as $currentNode) {
            if (!isset($node)) {
                $node = $currentNode;
                continue;
            }
            // Take the largest xpath for the current breadcrumbs
            if (count(explode('/', $currentNode->getXpath())) >= count(explode('/', $node->getXpath()))) {
                $node = $currentNode;
            }
        }

        // We may get a CMS page which actually has no nodes
        if (!isset($node)) {
            $crumbs['current_page'] = array(
                'label' => $this->getHelper('cms/page')->getPage()->getTitle(),
                'title' => $this->getHelper('cms/page')->getPage()->getTitle(),
            );
            return $crumbs;
        }

        // #4
        $hierarchy = array();
        $hierarchy['parent_nodes'] = explode('/', $node->getXpath());
        $hierarchy['level'] = $node->getLevel();
        if (isset($hierarchy['parent_nodes']) && $hierarchy['parent_nodes'] && $hierarchy['level'] > 1) {
            $nodeFilter = array();
            for ($i = 0; $i < count($hierarchy['parent_nodes']); $i++) {
                $nodeFilter[] = array('eq' => $hierarchy['parent_nodes'][$i]);
            }
            $parentNodes = $hierarchyModel
                ->getCollection()
                ->addFieldToFilter('node_id', $nodeFilter)
            ;
            $pageIdFilter = array();

            foreach($parentNodes as $node) {
                if($node->getPageId()){
                    $pageIdFilter[] = array('eq' => $node->getPageId());
                    $pageIdAssoc[$node->getLevel()] = $node->getPageId();
                }else{
                    $ids = Mage::getSingleton('cms/page')
                        ->getCollection()
                        ->addFieldToFilter('identifier', $node->getData('identifier').'.html');
                    foreach($ids as $id) {

                        $idH = $id->getData('page_id');
                        $pageIdFilter[] = array('eq' => $idH);
                        $pageIdAssoc[$node->getLevel()] = $idH;
                    }
                }
            }

            // Get the pages so we can echo their title and full URL
            // #5

            $cmsPages = Mage::getSingleton('cms/page')
                ->getCollection()
                ->addFieldToFilter('page_id', $pageIdFilter)
            ;
            // Make sure we're getting back the same amount of pages as we asked for

            if ($cmsPages->count() == count($pageIdAssoc)) {
                for($i = 1; $i < count($pageIdAssoc); $i++) {
                    $doNotAddPage = false;
                    // Begin putting the pages in their proper order
                    foreach($cmsPages as $page) {
                        if ($pageIdAssoc[$i] == $page->getPageId()) {
                            // #6
                            if (!$page->getIsActive()) {
                                $doNotAddPage = true;
                                break;
                            }
                            $currentPage = $page;
                            break;
                        }
                    }
                    if ($doNotAddPage) {
                        continue;
                    }

                    $crumbs[$currentPage['title']] = array(
                        'label' => $currentPage['title'],
                        'title' => $currentPage['title'],
                        'link' => Mage::getBaseUrl() . $currentPage['identifier'],
                    );
                    unset($currentPage);
                }
            }
        }

        // #7
        $crumbs['current_page'] = array(
            'label' => $this->getHelper('cms/page')->getPage()->getTitle(),
            'title' => $this->getHelper('cms/page')->getPage()->getTitle(),
        );

        // #8
        return $crumbs;
    }

    protected function _toHtml()
    {
        $hierarchyModel = Mage::getSingleton('enterprise_cms/hierarchy_node');
        $inHierarchy = $hierarchyModel
            ->getCollection()
            ->addFieldToFilter('page_id', $this->getHelper('cms/page')->getPage()->getPageId())
        ;
        $request = $this->getRequest();
        $route = $request->getRouteName();
        if (strtolower($route) == 'cms') {
            $page = $this->getHelper('cms/page')->getPage();
            // Ripped from Mage_Cms_Block_Page in _prepareLayout() as we override their breadcrumbs with ours
            if (Mage::getStoreConfig('web/default/show_cms_breadcrumbs')
                && ($breadcrumbs = $this->getLayout()->getBlock('breadcrumbs'))
                && ($page->getIdentifier()!==Mage::getStoreConfig('web/default/cms_home_page'))
                && ($page->getIdentifier()!==Mage::getStoreConfig('web/default/cms_no_route'))
                && $inHierarchy->getData()) {
                $this->_crumbs = $this->getCmsBreadcrumbs();
            }
        }
        // Delete null entry
        if ($this->_crumbs) {
            foreach ($this->_crumbs as $crumbName => $crumbInfo) {
                if (is_null($crumbInfo['label'])) {
                    unset($this->_crumbs[$crumbName]);
                }
            }
        }
        return parent::_toHtml();
    }
}