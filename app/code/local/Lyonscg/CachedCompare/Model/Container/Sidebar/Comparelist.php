<?php

class Lyonscg_CachedCompare_Model_Container_Sidebar_Comparelist extends Enterprise_PageCache_Model_Container_Sidebar_Comparelist
{
    /** @var $_placeholderBlock Mage_Core_Block_Abstract */
    protected $_placeholderBlock = null;
    /**
     * Get Place Holder Block
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _getPlaceHolderBlock()
    {
        if (null === $this->_placeholderBlock)
        {
            $this->_placeholderBlock = $this->_createBlock();
            $this->_placeholderBlock->setLayout(Mage::app()->getLayout());
            $this->_placeholderBlock->setSkipRenderTag(true);
        }
        return $this->_placeholderBlock;
    }

    protected function _createBlock()
    {
        $blockName = $this->_placeholder->getAttribute('block');
        $block = new $blockName;
        $template = $this->_placeholder->getAttribute('template');
        $productId = $this->_getProductId();

        $block->setProductId($productId);
        $block->setTemplate($template);

        return $block;
    }
}