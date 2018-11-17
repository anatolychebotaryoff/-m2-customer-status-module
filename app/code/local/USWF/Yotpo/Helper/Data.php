<?php
/**
 * Data.php
 *
 * @category    USWF
 * @package     USWF_Yotpo
 * @copyright
 * @author
 */
class USWF_Yotpo_Helper_Data extends Yotpo_Yotpo_Helper_Data
{

    public function showWidget($thisObj, $product = null, $print=true)
    {

        if ($product->getTypeId() == 'grouped') {

            $_associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);
            
            foreach ($_associatedProducts as $_associatedProduct)
            {

                if ($_associatedProduct->getTypeId() == 'simple')
                {

                    return parent::showWidget($thisObj, $_associatedProduct, $print);

                }

            }

        }

        if ($product->getTypeId() == 'bundle') {
            $selections = $product->getTypeInstance(true)->getSelectionsCollection($product->getTypeInstance(true)->getOptionsIds($product), $product);
            
            if (sizeOf($selections) > 0) {
            
                foreach($selections as $selection) {
                    return parent::showWidget($thisObj, $selection, $print);
                }

            }

        }

        parent::showWidget($thisObj, $product, $print);

    }


    public function showBottomLine($thisObj, $product = null, $print=true)
    {

        if ($product->getTypeId() == 'grouped') {

            $_associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);

            foreach ($_associatedProducts as $_associatedProduct)
            {

                if ($_associatedProduct->getTypeId() == 'simple')
                {

                    return parent::showBottomLine($thisObj, $_associatedProduct, $print);

                }

            }

        }

        if ($product->getTypeId() == 'bundle') {
            $selections = $product->getTypeInstance(true)->getSelectionsCollection($product->getTypeInstance(true)->getOptionsIds($product), $product);
            
            if (sizeOf($selections) > 0) {
            
                foreach($selections as $selection) {
                    return parent::showBottomLine($thisObj, $selection, $print);
                }

            }

        }


        return parent::showBottomLine($thisObj, $product, $print);

    } 

    
    public function showQABottomLine($thisObj, $product = null, $print=true)
    {

        if ($product->getTypeId() == 'grouped') {

            $_associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);

            foreach ($_associatedProducts as $_associatedProduct)
            {

                if ($_associatedProduct->getTypeId() == 'simple')
                {

                    return parent::showQABottomLine($thisObj, $_associatedProduct, $print);

                }

            }

        }

        if ($product->getTypeId() == 'bundle') {
            $selections = $product->getTypeInstance(true)->getSelectionsCollection($product->getTypeInstance(true)->getOptionsIds($product), $product);
            
            if (sizeOf($selections) > 0) {
            
                foreach($selections as $selection) {
                    return parent::showQABottomLine($thisObj, $selection, $print);
                }

            }

        }

        return parent::showQABottomLine($thisObj, $product, $print);

    } 



}
