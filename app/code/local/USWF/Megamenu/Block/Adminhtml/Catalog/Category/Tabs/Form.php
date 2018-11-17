<?php

class USWF_Megamenu_Block_Adminhtml_Catalog_Category_Tabs_Form extends Cmsmart_Megamenu_Block_Catalog_Category_Tabs_Form
{

    protected $categoryArr;

    protected function _prepareForm()
    {
        parent::_prepareForm();
        $this->setTemplate('uswf/cmsmart/megamenu/menutop.phtml');
        return $this;
    }

    /**
     * @param $keyCheck
     * @param null $valueCheck
     * @return bool
     */
    protected function checkCategoryArr($keyCheck, $valueCheck = null)
    {
        $categoryArr = $this->getCategoryArr();

        if ($valueCheck == null &&
            array_key_exists(0,$categoryArr)) {
            return $categoryArr[0][$keyCheck];
        }

        if (array_key_exists(0,$categoryArr) &&
            $categoryArr[0][$keyCheck] == $valueCheck) {
            return true;
        }

        return false;
    }

    protected function getCategoryArr()
    {
        if (!$this->categoryArr) {
            $theme = $this->helper('megamenu');
            $this->categoryArr = $theme->getCategoryArr();
        }
        return $this->categoryArr;
    }
}
