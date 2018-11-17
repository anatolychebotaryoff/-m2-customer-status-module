<?php
/**
 * Created by JetBrains PhpStorm.
 * User: yscherba@speroteck.com
 * Date: 25.04.14
 * Time: 14:17
 * Helper
 *
 * @category Lyons
 * @package  Lyonscg_Usff
 */
class Lyonscg_Usff_Helper_Data extends Mage_Core_Helper_Data
{
    /**
     * @param $array
     * @param $blockIdent
     * @return mixed
     */
    public function setVariableInCmsBlock($array, $blockIdent)
    {
        $block = Mage::getModel('cms/block')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($blockIdent);
        $filter = Mage::getModel('cms/template_filter');
        $filter->setVariables($array);

        return $filter->filter($block->getContent());
    }
}