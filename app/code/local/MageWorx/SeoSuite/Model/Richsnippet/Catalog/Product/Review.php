<?php
/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @copyright  Copyright (c) 2013 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */
/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */

/**
 * @see MageWorx_SeoSuite_Block_Review_Helper
 */
class MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Review extends MageWorx_SeoSuite_Model_Richsnippet_Catalog_Product_Abstract
{
    protected $_reviewData = array();

    protected function _beforeRender($html)
    {
        /**
         * Only main product
         */
        if (!Mage::registry('current_product') || $this->_product->getId() != Mage::registry('current_product')->getId()) {
            return false;
        }
        $reviewModel       = Mage::getModel('review/review_summary');
        $this->_reviewData = $reviewModel->setStoreId(Mage::app()->getStore()->getId())->load($this->_product->getId());
        if (is_object($this->_reviewData)) {
            return true;
        }
        return false;
    }

    protected function _checkBlockType()
    {
        return true;
    }

    protected function _isValidNode(simple_html_dom_node $node)
    {
        $parentNode = $this->_findParentContainer($node);
        if (!$parentNode) {
            return false;
        }
        $grandParentNode = $this->_findParentContainer($parentNode);
        if (!$grandParentNode) {
            return false;
        }
        if (!$this->_isNotInsideTypes($node)) {
            return false;
        }
        return true;
    }

    protected function _addAttributeForNodes(simple_html_dom_node $node)
    {

        if ($this->_reviewData['reviews_count'] == 0) return true;

        $parentNode            = $this->_findParentContainer($node);
        $parentNode->itemtype  = 'http://schema.org/AggregateRating';
        $parentNode->itemscope = "";
        $parentNode->itemprop  = 'aggregateRating';
        $this->_addRatingValueMetaTag($node, $this->_reviewData['rating_summary']);
        $this->_addReviewCountMetaTag($node, $this->_reviewData['reviews_count']);
        $this->_addBestRatingMetaTag($node);
        $this->_addWorstRatingMetaTag($node);
        return true;
    }

    protected function _getItemConditions()
    {
        $conditions   = array();
        $reviewModel  = Mage::getModel('review/review_summary');
        $rating       = $reviewModel->setStoreId(Mage::app()->getStore()->getId())->load($this->_product->getId())->getRatingSummary();
        $conditions[] = "div[class=rating], div[style=width:{$rating}%]";
        return $conditions;
    }

    protected function _afterRender()
    {
        $report = new Varien_Object(array('status' => 'success'));
        Mage::register('mageworx_richsnippet_aggregate_rating_report', $report, true);
        return parent::_afterRender();
    }

    protected function _addRatingValueMetaTag($node, $ratingValue)
    {
        $node->outertext = '<meta itemprop="ratingValue" content="' . $ratingValue . '"/>' . $node->outertext;
    }

    protected function _addReviewCountMetaTag($node, $reviewCount)
    {
        $node->outertext = '<meta itemprop="reviewCount" content="' . $reviewCount . '"/>' . $node->outertext;
    }

    protected function _addWorstRatingMetaTag($node, $worstRating = 0)
    {
        $node->outertext = '<meta itemprop="worstRating" content="' . $worstRating . '">' . $node->outertext;
    }

    protected function _addBestRatingMetaTag($node, $bestRating = 100)
    {
        $node->outertext = '<meta itemprop="bestRating" content="' . $bestRating . '">' . $node->outertext;
    }
}
