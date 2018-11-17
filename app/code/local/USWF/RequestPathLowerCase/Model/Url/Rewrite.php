<?php

class USWF_RequestPathLowerCase_Model_Url_Rewrite extends Enterprise_UrlRewrite_Model_Url_Rewrite
    implements Mage_Core_Model_Url_Rewrite_Interface
{


    const REWRITE_MATCHERS_PATH          = 'default/rewrite_matchers';

    const REWRITE_MATCHERS_PRIORITY_PATH = 'rewrite_matchers/%s/priority';

    const REWRITE_MATCHERS_TITLE_PATH    = 'rewrite_matchers/%s/title';

    const REWRITE_MATCHERS_MODEL_PATH    = 'rewrite_matchers/%s/model';

    /**
     * Load url rewrite entity by request_path
     *
     * @param array $paths
     * @return Enterprise_UrlRewrite_Model_Url_Rewrite
     */
    public function loadByRequestPath($paths)
    {
        $this->setId(null);

        //USWF modification
        //Cast the array to lower so the search is in lowercase
        if (is_array($paths)) {
            $paths = array_map('strtolower', $paths);
        }

        $rewriteRows = $this->_getResource()->getRewrites($paths);

        $matchers = $this->_factory->getSingleton('enterprise_urlrewrite/system_config_source_matcherPriority')
            ->getRewriteMatchers();

        foreach ($matchers as $matcherIndex) {
            $matcher = $this->_factory->getSingleton($this->_factory->getConfig()->getNode(
                sprintf(self::REWRITE_MATCHERS_MODEL_PATH, $matcherIndex), 'default'
            ));
            foreach ($rewriteRows as $row) {
                if ($matcher->match($row, $paths['request'])) {
                    $this->setData($row);
                    break(2);
                }
            }
        }
        $this->_afterLoad();
        $this->setOrigData();
        $this->_hasDataChanges = false;
        return $this;
    }

}
