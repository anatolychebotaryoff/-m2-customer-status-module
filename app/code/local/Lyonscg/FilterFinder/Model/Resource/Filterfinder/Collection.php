<?php
/**
 * Lyonscg_FilterFinder
 *
 * @category    Lyonscg
 * @package     Lyonscg_FilterFinder
 * @copyright   Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author      Ashutosh Potdar (apotdar@lyonscg.com)
 */

/**
 * Filterfinder action resource colleciton
 *
 * @category Lyons
 * @package  Lyonscg_FilterFinder
 */
class Lyonscg_FilterFinder_Model_Resource_Filterfinder_Collection
        extends Mage_Core_Model_Resource_Db_Collection_Abstract
{

    /**
     * Initialize collection
     */
    public function _construct()
    {
        $this->_init('lyonscg_filterfinder/filterfinder');
    }
}
