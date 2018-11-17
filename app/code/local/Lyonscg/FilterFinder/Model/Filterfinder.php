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
 * Filterfinder Model
 *
 * @category Lyons
 * @package  Lyonscg_FilterFinder
 */
class Lyonscg_FilterFinder_Model_Filterfinder
        extends Mage_Core_Model_Abstract
{
    /**
     * Constructor
     */
    public function _construct()
    {
        $this->_init('lyonscg_filterfinder/filterfinder');
    }
}
