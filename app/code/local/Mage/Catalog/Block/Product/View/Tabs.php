<?php
/**
 * Magento Enterprise Edition
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Magento Enterprise Edition License
 * that is bundled with this package in the file LICENSE_EE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.magentocommerce.com/license/enterprise-edition
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    Mage
 * @package     Mage_Catalog
 * @copyright   Copyright (c) 2013 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://www.magentocommerce.com/license/enterprise-edition
 */


/**
 * Product information tabs
 *
 * @category   Mage
 * @package    Mage_Catalog
 * @author     Magento Core Team <core@magentocommerce.com>
 */
class Mage_Catalog_Block_Product_View_Tabs extends Mage_Core_Block_Template
{
    protected $_tabs = array();

	protected function _construct()
	{
		parent::_construct();
	
		$this->addData(array(
			'cache_lifetime' => 48*60*60,
			'cache_tags' => array(
				Mage_Catalog_Model_Product::CACHE_TAG
			)
		));
	}

	public function getCacheKeyInfo()
	{
		return array_merge(parent::getCacheKeyInfo(), array(		
			(int)Mage::app()->getStore()->isCurrentlySecure(),
                        Mage::app()->getStore()->getId(),
                        Mage::registry("current_product")->getId(),
			(int)$this->helper('customer')->isLoggedIn()
		));
        }


    /**
     * Add tab to the container
     *
     * @param string $title
     * @param string $block
     * @param string $template
     */
    function addTab($alias, $title, $block, $template)
    {

        if (!$title || !$block || !$template) {
            return false;
        }

        $this->_tabs[] = array(
            'alias' => $alias,
            'title' => $title
        );

        $this->setChild($alias,
            $this->getLayout()->createBlock($block, $alias)
                ->setTemplate($template)
            );
    }

    function getTabs()
    {
        return $this->_tabs;
    }
}
