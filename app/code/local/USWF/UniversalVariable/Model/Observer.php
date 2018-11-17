<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     USWF_UniversalVariable
 * @copyright
 * @author
 */
class USWF_UniversalVariable_Model_Observer
{
    const CAMPAIGN_PARAM_PATTERN = '/%s=*/';
    
    /**
     * Extracts ans stores to cookie the email from conversion link if it is presented
     *
     * @param $observer
     * @return $this
     */
    public function setCampaignEmail($observer)
    {
        if (
            Mage::app()->getRequest()->isGet() && 
            !Mage::app()->getRequest()->isAjax() &&
            ($paramName = Mage::helper('uswf_universalvariable')->getCampaignEmailParamName()) &&
            ($email = Mage::app()->getRequest()->getParam($paramName))
        ) {

            if (!base64_decode($email, true)) {
                Mage::helper('uswf_universalvariable')->setCampaignEmail('');
                return;
            }

            $cache = Mage::app()->getCacheInstance();
            $cache->banUse('full_page');
            Mage::helper('uswf_universalvariable')->setCampaignEmail(base64_decode($email));
            $parsedUrl = parse_url(Mage::helper('core/url')->getCurrentUrl());
            if (isset($parsedUrl['query'])) {
                $params = explode('&', $parsedUrl['query']);
                $pattern = sprintf(
                    self::CAMPAIGN_PARAM_PATTERN,
                    Mage::helper('uswf_universalvariable')->getCampaignEmailParamName()
                );
                foreach ($params as $key => $value) {
                    if (preg_match($pattern, $value)) {
                        unset($params[$key]);
                    }
                }
            }
            $scheme   = isset($parsedUrl['scheme']) ? $parsedUrl['scheme'] . '://' : ''; 
            $host     = isset($parsedUrl['host']) ? $parsedUrl['host'] : '';
            $path     = isset($parsedUrl['path']) ? $parsedUrl['path'] : ''; 
            $query    = !empty($params) ? '?' . implode('&', $params) : ''; 
            $fragment = isset($parsedUrl['fragment']) ? '#' . $parsedUrl['fragment'] : '';
            $observer->getEvent()->getControllerAction()->setFlag('', 'no-dispatch', true);
            Mage::app()->getResponse()
                ->setRedirect("$scheme$host$path$query$fragment");
        }
    }
}
