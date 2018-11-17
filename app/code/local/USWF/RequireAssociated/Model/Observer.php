<?php

class USWF_RequireAssociated_Model_Observer {

    public function catalogProductSaveBefore ( $observer ) {


        $product = $observer->getEvent()->getProduct();

        $productType = $product->getTypeId();



        if ( $product->getStatus() == 2 ) { return; }

        if ( $productType == "grouped" ) {

            $associatedProducts = $product->getTypeInstance(true)->getAssociatedProducts($product);

            if (sizeOf($associatedProducts) == 0 ) {
                Mage::getSingleton("core/session")->addError("Group products must have associated products in order to be enabled");     
                $product->setData( "status", 2 );
                //$product->save();
            }

        } else if ( $productType == "bundle" ) {

            $bundled_product = Mage::getModel("catalog/product")->load($product->getId());

            if (sizeOf($product->getTypeInstance()->getOptionsIds()) == 0) {
                Mage::getSingleton("core/session")->addError("Bundle products must have children in order to be enabled");
                $product->setData( "status", 2 );
                //$product->save();
            }

        }

    }

}
