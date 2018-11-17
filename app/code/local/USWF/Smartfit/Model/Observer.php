<?php
/**
 * Observer.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Model_Observer 
{
    /**
     * Fix for Cmsmart_Megamenu extension
     * 
     * @param Varien_Event_Observer $observer
     * @return  USWF_Smartfit_Model_Observer
     */
    public function checkLayouts(Varien_Event_Observer $observer) {
        //do nothing because of conditional block unsetting in cmsmart_megamenu.xml
        return $this;
    }

    /**
     * Fix for Cmsmart_Megamenu extension
     *
     * @param Varien_Event_Observer $observer
     * @return  USWF_Smartfit_Model_Observer
     */
    public function saveCategoryTop(Varien_Event_Observer $observer)
    {
        $dat          = $observer->getRequest()->getParams();
        $categoryId   = $observer->getCategory()->getId();

        $read         = Mage::getSingleton('core/resource')->getConnection('core_read');

        $data['category_id'] = $categoryId;

        if(@$dat['active_product']){
            $data['active_product']            = @$dat['active_product'];
        } else {
            $data['active_product']            = 0;
        }
        $data['numbers_product']                       = @$dat['numbers_product'];

        if(@$dat['active_width']){
            $data['active_width']            = @$dat['active_width'];
        } else {
            $data['active_width']            = 0;
        }

        $data['width_level']                       = @$dat['width_level'];

        if(@$dat['active_static_block_top']) {
            $data['active_static_block_top']             = @$dat['active_static_block_top'];
        } else {
            $data['active_static_block_top']             = 0;
        }
        $data['static_block_top']                      = @$dat['static_block_top'];
        if(@$dat['active_static_block']){
            $data['active_static_block']             = $dat['active_static_block'];
        } else {
            $data['active_static_block']             = 0;
        }

        if(@$dat['active_static_block_left']) {
            $data['active_static_block_left']            = @$dat['active_static_block_left'];
        } else {
            $data['active_static_block_left']            = 0;
        }

        $data['static_block_left']                     = @$dat['static_block_left'];
        if(@$dat['active_static_block_bottom']) {
            $data['active_static_block_bottom']          = @$dat['active_static_block_bottom'];
        } else {
            $data['active_static_block_bottom']          = 0;
        }
        $data['static_block_bottom']                   = @$dat['static_block_bottom'];
        if(@$dat['active_static_block_right']) {
            $data['active_static_block_right']           = @$dat['active_static_block_right'];
        } else {
            $data['active_static_block_right']           = 0;
        }
        $data['static_block_right']                    = @$dat['static_block_right'];
        if(@$dat['active_label']) {
            $data['active_label']                        = @$dat['active_label'];
        } else {
            $data['active_label']                        = 0;
        }
        $data['label']                                 = @$dat['label'];
        if(@$dat['active_thumbail']) {
            $data['active_thumbail']                     = @$dat['active_thumbail'];
        } else {
            $data['active_thumbail']                     = 0;
        }
        $data['level_column_count']                   = @$dat['level_column_count'];
        if(@$dat['hidden_menutop']) {
            $data['hidden_menutop']                = @$dat['hidden_menutop'];
        } else {
            $data['hidden_menutop']                = 0;
        }
        if(@$dat['category_children']) {
            $data['category_children']                = @$dat['category_children'];
        } else {
            $data['category_children']                = 0;
        }
        if(@$dat['width_block_left']) {
            $data['width_block_left']                = @$dat['width_block_left'];
        } else {
            $data['width_block_left']                = 0;
        }
        if(@$dat['width_block_right']) {
            $data['width_block_right']                = @$dat['width_block_right'];
        } else {
            $data['width_block_right']                = 0;
        }
        if(@$dat['width_children']) {
            $data['width_children']                = @$dat['width_children'];
        } else {
            $data['width_children']                = 0;
        }
        if(@$dat['font-color']) {
            $data['font-color']                = @$dat['font-color'];
        } else {
            $data['font-color']                = '';
        }
        if(@$dat['background-color']) {
            $data['background-color']                = @$dat['background-color'];
        } else {
            $data['background-color']                = '';
        }
        if(@$dat['hide_menutop']) {
            $data['hide_menutop']                = @$dat['hide_menutop'];
        } else {
            $data['hide_menutop']                = 0;
        }
        $model = Mage::getModel('megamenu/megamenu');
        $model->setData($data);
        $dataorthe = Mage::helper('megamenu')->getCategoryArr();
        if(isset($dataorthe[0]['adminmenutop_id']) && $dataorthe[0]['adminmenutop_id']){
            $id = $dataorthe[0]['adminmenutop_id'];
            $model = Mage::getModel('megamenu/megamenu')->load($id)->addData($data);
            try {
                $model->setId($id)->save();
            } catch(Exception $e) {}
        } else {
            try
            {
                $model->save();
            }
            catch (Exception $e) {}
        }
    }
}