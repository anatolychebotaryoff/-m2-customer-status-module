<?php
/**
 * GoogleTrustedStore module for overriding Mage_GoogleTrustedStore_Model_Feeder
 *
 * @category   Lyons
 * @package    Lyonscg_GoogleTrustedStore
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */ 
class Lyonscg_GoogleTrustedStore_Model_Feeder extends Mage_GoogleTrustedStore_Model_Feeder
{
    /**
     * Override generateFeeds since Aoe_Scheduler passes first argument as Aoe_Scheduler Object instead of array
     *
     * @param null $stores
     * @param null $manual
     * @throws Exception
     */
    public function generateFeeds($stores = null, $manual = null)
    {
        /* #409491 - disable google trusted store feeds */
        return;

        /*
        try {
            if (!$stores || !is_array($stores)) {
                $stores = Mage::app()->getStores();
            }
            parent::generateFeeds($stores, $manual);
        } catch (RuntimeException $e) {
            $message = 'GoogleTrustedStore: ' . $e->getMessage();
            Mage::log($message);
            if ($manual) {
                throw new Exception($message);
            }
        }
        */
    }

    /**
     * Override uploadFeeds since Aoe_Scheduler passes first argument as Aoe_Scheduler Object instead of array
     *
     * @param null $stores
     * @param null $manual
     * @throws Exception
     */
    public function uploadFeeds($stores = null, $manual = null)
    {
        /* #409491 - disable google trusted store feeds */
        return;

        /*
        try {
            if (!$stores || !is_array($stores)) {
                $stores = Mage::app()->getStores();
            }
            parent::uploadFeeds($stores, $manual);
        } catch (Varien_Io_Exception $e) {
            $message = Mage::helper('googletrustedstore')->__('GoogleTrustedStore FTP upload error:') .
                ' ' . $e->getMessage();
            Mage::log($message);
            if ($manual) {
                throw new Exception($message);
            }
        }
        */
    }
}