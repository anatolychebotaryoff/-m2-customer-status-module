<?php
/**
 * Lyonscg_RewriteParams 
 *
 * @category  Lyonscg
 * @package   Lyonscg_RewriteParams
 * @copyright Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author    Todd Wolaver (twolaver@lyonscg.com)
 */

/**
 * Helper
 *
 * @category Lyons
 * @package  Lyons_RewriteParams
 */
class Lyonscg_RewriteParams_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * Process target URL
     *
     * Add approved _GET parameters to the target URL
     *
     * @param  string $targetUrl
     * @return string
     */
    public function processTargetUrl($targetUrl)
    {
        $passThrough   = Mage::getStoreConfigFlag('web/seo/rewrite_passthrough_params');

        $requestParams = $_GET;
        $targetParts   = parse_url($targetUrl);

        $targetParams  = array();
        if (isset($targetParts['query'])) {
            $targetParams = parse_str($targetParts['query']);
        }

        if ($passThrough) {
            // Pass through all params, so just get the keys from the request params
            $params = array_keys($requestParams);
        } else {
            // Get just the allowed params on the current request
            $params = array_intersect(array_keys($requestParams), $this->getAllowedGetParams());
        }

        // Add allowed params to the target params. If a param is already set on
        // the target, ignore the _GET value, keeping the predefined value
        foreach ($params as $allowedParam) {
            // If param is already set on the target, don't use the one form _GET
            if (isset($targetParams[$allowedParam])) {
                continue;
            }
            $targetParams[$allowedParam] = $requestParams[$allowedParam];
        }

        // Reassemble the query string from the target params array
	if( ! empty($targetParams) ) {
        	$targetParts['query'] = http_build_query($targetParams);
	}

        // Reassemble the URL (assuming we don't have http_build_url from PECL)
        $targetUrl =
            ((isset($targetParts['scheme'])) ? $targetParts['scheme'] . '://' : '') .
            ((isset($targetParts['user'])) ? $targetParts['user'] . ((isset($targetParts['pass']))
                    ? ':' . $targetParts['pass'] : '') .'@'
                    : '') .
            ((isset($targetParts['host'])) ? $targetParts['host'] : '') .
            ((isset($targetParts['port'])) ? ':' . $targetParts['port'] : '') .
            ((isset($targetParts['path'])) ? $targetParts['path'] : '') .
            ((isset($targetParts['query'])) ? '?' . $targetParts['query'] : '') .
            ((isset($targetParts['fragment'])) ? '#' . $targetParts['fragment'] : '')
            ;

        return trim($targetUrl, '?');
    }

    /**
     * Get allowed _GET params via system configuration
     *
     * @return array
     */
    public function getAllowedGetParams()
    {
        $allowedParams = Mage::getStoreConfig('web/seo/rewrite_allowed_params');
        $allowedParams = explode(',', $allowedParams);

        // Cleanup the params just in case there are spaces with the commas
        foreach ($allowedParams as $key => $value) {
            $allowedParams[$key] = trim($value);
        }

        return $allowedParams;
    }
}
