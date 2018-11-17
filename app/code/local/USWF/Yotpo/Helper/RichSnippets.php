<?php

class USWF_Yotpo_Helper_RichSnippets extends Yotpo_Yotpo_Helper_RichSnippets
{
    private $_config;

    public function __construct ()
    {
        $this->_config = Mage::getStoreConfig('yotpo');
    }

    public function getRichSnippet()
    {

                

        try {

            $cache = Mage::app()->getCache();
            $_product = Mage::registry('product');

            if ($_product->getTypeId() == 'grouped') {

                $_associatedProducts = $_product->getTypeInstance(true)->getAssociatedProducts($_product);
    
                foreach ($_associatedProducts as $_associatedProduct)
                {

                    if ($_associatedProduct->getTypeId() == 'simple')
                    {
                        $_product = $_associatedProduct;        
                    }
                }

            }

            if ($_product->getTypeId() == 'bundle') {
                $selections = $_product->getTypeInstance(true)->getSelectionsCollection($_product->getTypeInstance(true)->getOptionsIds($_product), $_product);
            
                if (sizeOf($selections) > 0) {
            
                    foreach($selections as $selection) {
                        $_product = $selection;
                        break;
                    }

                }

            }

            

            $productId = $_product->getId();

            $cachedSnippet = $cache->load("PRODUCT_YOTPO_" . $productId . "_" . Mage::app()->getStore()->getId());

            if ($cachedSnippet != null && $cachedSnippet != "" && $cachedSnippet != "NOTFOUND") {
                return (array) json_decode($cachedSnippet);
            }
            

            $snippet = Mage::getModel('yotpo/richsnippet')->getSnippetByProductIdAndStoreId($productId, Mage::app()->getStore()->getId());
            
            if (($snippet == null) || (!$snippet->isValid())) {
                //no snippet for product or snippet isn't valid anymore. get valid snippet code from yotpo api
                
                $res = Mage::helper('yotpo/apiClient')->createApiGet("products/".($this->getAppKey())."/richsnippet/".$productId, 2);


                
                if ($res["code"] != 200) {
                    //product not found or feature disabled.
                    $cache->save( "NOTFOUND", "PRODUCT_YOTPO_" . $productId . "_" . Mage::app()->getStore()->getId(), array(), 3600);
                    return "";
                }

                $body = $res["body"];
                $averageScore = $body->response->rich_snippet->reviews_average;
                $reviewsCount = $body->response->rich_snippet->reviews_count;
                $ttl = $body->response->rich_snippet->ttl;

                if ($snippet == null) {
                    $snippet = Mage::getModel('yotpo/richsnippet');
                    $snippet->setProductId($productId);
                    $snippet->setStoreId(Mage::app()->getStore()->getid());
                }

                $snippet->setAverageScore($averageScore);
                $snippet->setReviewsCount($reviewsCount);
                $snippet->setExpirationTime(date('Y-m-d H:i:s', time() + $ttl));
                $snippet->save();
                
                $cache->save( json_encode(array( "average_score" => $averageScore, "reviews_count" => $reviewsCount)), "PRODUCT_YOTPO_" . $productId . "_" . Mage::app()->getStore()->getId(), array(), 3600);

                return array( "average_score" => $averageScore, "reviews_count" => $reviewsCount);
            }
            $cache->save( json_encode(array( "average_score" => $snippet->getAverageScore(), "reviews_count" => $snippet->getReviewsCount())), "PRODUCT_YOTPO_" . $productId . "_" . Mage::app()->getStore()->getId(), array(), 3600);
            return array( "average_score" => $snippet->getAverageScore(), "reviews_count" => $snippet->getReviewsCount());

        } catch(Exception $e) {
            Mage::log($e);
        }
        return array();
    }

    private function getAppKey()
    {
        return trim(Mage::getStoreConfig('yotpo/yotpo_general_group/yotpo_appkey',Mage::app()->getStore()));
    }
}
