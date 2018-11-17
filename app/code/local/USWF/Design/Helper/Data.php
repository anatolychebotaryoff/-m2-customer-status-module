<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_Design
 * @copyright
 * @author
 */
class USWF_Design_Helper_Data extends Mage_Catalog_Helper_Data
{
    protected $disclaimerLinkMap = array(
        'dfs_en' => 'privacy-and-security.html',
        'ff_en' => 'privacy-and-security.html',
        'wfn_en' => 'privacy-security-policy.html'
    );
    
    /**
     * Returns disclaimer html
     *
     * @return string
     */
    public function getDisclaimerHtml() {
        $store = Mage::app()->getStore();
        return sprintf(
            $this->__('*You will receive information regarding your purchase, periodic email updates, news and special offers from %s %s.'),
            $store->getWebsite()->getName(),
            sprintf(
                $this->__('<a href="%s">privacy policy</a>'),
                isset($this->disclaimerLinkMap[$store->getCode()]) ? 
                    Mage::getUrl($this->disclaimerLinkMap[$store->getCode()], array('_fragment' => 'unsubscribe')) : ''
            )
        );
    }
}