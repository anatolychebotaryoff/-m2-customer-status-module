<?php
/**
 * Full Page Cache Container for Qubit UniversalVariable module
 *
 * @category   Lyons
 * @package    us_waterfilters
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */

/**
 * Uv Container
 */
class Lyonscg_UniversalVariable_Model_Container_Uv extends Enterprise_PageCache_Model_Container_Abstract
{
    /**
     * Get identifier from cookies
     *
     * @return string
     */
    protected function _getIdentifier()
    {
        $cacheId = $this->_getCookieValue(Enterprise_PageCache_Model_Cookie::COOKIE_CUSTOMER, '')
            . '_'
            . $this->_getCookieValue(Enterprise_PageCache_Model_Cookie::COOKIE_CUSTOMER_LOGGED_IN, '')
            . '_'
            . $this->_getCookieValue(Enterprise_PageCache_Model_Cookie::COOKIE_CART, '')
            . '_'
            . $this->_getProductId()
            . '_'
            . $this->_getCategoryId()
            . '_'
            // The following is not terribly efficient, but the UV block
            // changes on every page.  If the block could be made a bit
            // smarter we could make the caching a bit more universal.
            . $_SERVER['REQUEST_URI'];

        return $cacheId;
    }

    /**
     * Get cache identifier
     *
     * @return string
     */
    protected function _getCacheId()
    {
        return 'CONTAINER_UV_' . md5($this->_placeholder->getAttribute('cache_id') . $this->_getIdentifier());
    }

    /**
     * Render block content
     *
     * @return string
     */
    protected function _renderBlock()
    {
        $layout = Mage::app()->getLayout();
        $layout->createBlock('QuBit_UniversalVariable_Block_Uv','universal_variable');

        // Check if qubit universal variable block exist
        if ($block = Mage::app()->getLayout()->getBlock('universal_variable')) {
            $block->setTemplate('qubit/universal_variable.phtml');
            Mage::dispatchEvent('lyonscg_universalvariable_cache_observer', array('placeholder' => $this->_placeholder, 'current_category_id' => $this->_getCategoryId(), 'current_product_id' => $this->_getProductId()));
            return $block->toHtml();
        } else {
            return false;
        }
    }
}
