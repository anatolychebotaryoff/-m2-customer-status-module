<?php
/**
 * StoreFront CyberSource Tokenized Payment Extension for Magento
 *
 * PHP version 5
 *
 * LICENSE: This source file is subject to commercial source code license of StoreFront Consulting, Inc.
 *
 * @category  SFC
 * @package   SFC_CyberSource
 * @author    Garth Brantley <garth@storefrontconsulting.com>
 * @copyright 2009-2013 StoreFront Consulting, Inc. All Rights Reserved.
 * @license   http://www.storefrontconsulting.com/media/downloads/ExtensionLicense.pdf StoreFront Consulting Commercial License
 * @link      http://www.storefrontconsulting.com/cybersource-saved-credit-cards-extension-for-magento/
 *
 */

/**
 */
class SFC_CyberSource_Model_Source_Month
{
    /**
     * Retrieve Check Type Option array
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array(
                'value' => '01',
                'label' => Mage::helper('adminhtml')->__('01 - January')
            ),
            array(
                'value' => '01',
                'label' => Mage::helper('adminhtml')->__('01 - January')
            ),
            array(
                'value' => '02',
                'label' => Mage::helper('adminhtml')->__('02 - February')
            ),
            array(
                'value' => '03',
                'label' => Mage::helper('adminhtml')->__('03 - March')
            ),
            array(
                'value' => '04',
                'label' => Mage::helper('adminhtml')->__('04 - April')
            ),
            array(
                'value' => '05',
                'label' => Mage::helper('adminhtml')->__('05 - May')
            ),
            array(
                'value' => '06',
                'label' => Mage::helper('adminhtml')->__('06 - June')
            ),
            array(
                'value' => '07',
                'label' => Mage::helper('adminhtml')->__('07 - July')
            ),
            array(
                'value' => '08',
                'label' => Mage::helper('adminhtml')->__('08 - August')
            ),
            array(
                'value' => '09',
                'label' => Mage::helper('adminhtml')->__('09 - September')
            ),
            array(
                'value' => '10',
                'label' => Mage::helper('adminhtml')->__('10 - October')
            ),
            array(
                'value' => '11',
                'label' => Mage::helper('adminhtml')->__('11 - November')
            ),
            array(
                'value' => '12',
                'label' => Mage::helper('adminhtml')->__('12 - December')
            ),
        );
    }
}
