<?php
/**
 * Rewrite for MageWorx SeoSuite for sending review link on category page to product page instead of review page
 *
 * @category   Lyons
 * @package    Lyonscg_SeoSuite
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
class Lyonscg_SeoSuite_Block_Review_Helper extends MageWorx_SeoBase_Block_Review_Helper
{
    /**
     * Review url should be product page with an anchor to the review section
     *
     * @return string
     */
    public function getReviewsUrl() {
        $productUrl = $this->getProduct()->getProductUrl();
        return $productUrl . '#customer-reviews-header';
    }
}
