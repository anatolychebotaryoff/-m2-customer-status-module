<?php
require_once Mage::getModuleDir('controllers', 'Cmsmart_AjaxCart') . DS . 'IndexController.php';
class USWF_Smartfit_IndexController extends Cmsmart_AjaxCart_IndexController
{
	public function _getProductFromUrl(){
		Mage::dispatchEvent('catalog_controller_product_init_before', array('controller_action'=>$this));
		$product_id = $this->getRequest()->getParam('product');
		if(!$product_id):
			$path  = $this->getRequest()->getParam('id');
			$product_id = (int) $path;
	
			if(!$product_id){
				
				$path[0] == "\/" ? $path = substr($path, 1, strlen($path)) : $path;
				$tableName = Mage::getSingleton('core/resource')->getTableName('core_url_rewrite'); 
				$write = Mage::getSingleton('core/resource')->getConnection('core_write');
				
				$rs = $write->query('select `product_id` from `'.$tableName.'` where `request_path` = "'.$path.'"');
				
				if ($row = $rs->fetch() ) {
					$product_id = $row['product_id'];
				}	
			}
		endif;	

        if (!$product_id) {
            return false;
        }
		
        $product = Mage::getModel('catalog/product')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($product_id);

        if (!Mage::helper('catalog/product')->canShow($product)) {
            return false;
        }
        if (!in_array(Mage::app()->getStore()->getWebsiteId(), $product->getWebsiteIds())) {
            return false;
        }

        $category = Mage::registry('current_category');
        $categoryId = !empty($category) ? $category->getId() : false;
        if ($categoryId) {
            $category = Mage::getModel('catalog/category')->load($categoryId);
            $product->setCategory($category);
            Mage::register('current_category', $category);
        }
        elseif ($categoryId = Mage::getSingleton('catalog/session')->getLastVisitedCategoryId()) {
            if ($product->canBeShowInCategory($categoryId)) {
                $category = Mage::getModel('catalog/category')->load($categoryId);
                $product->setCategory($category);
                Mage::register('current_category', $category);
            }
        }
        Mage::register('current_product', $product);
        Mage::register('product', $product);

        try {
            Mage::dispatchEvent('catalog_controller_product_init', array('product'=>$product));
            Mage::dispatchEvent('catalog_controller_product_init_after', array('product'=>$product, 'controller_action' => $this));
        } catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            return false;
        }

        return $product;
	}


}