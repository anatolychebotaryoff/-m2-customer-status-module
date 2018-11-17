<?php
/**
 * USWF Brand Category Record
 *
 * @category    USWF
 * @package     USWF_BrandCategory
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_BrandCategory_Model_Resource_Record extends Mage_Core_Model_Resource_Db_Abstract
{
    protected function _construct()
    {
        $this->_init('uswf_brandcategory/record', 'id');
    }
}
