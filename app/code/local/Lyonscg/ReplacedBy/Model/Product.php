<?php
/**
 * Enter description here ...
 *
 * @category   Lyons
 * @package    Lyonscg_ReplacedBy
 * @copyright  Copyright (c) 2013 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
class Lyonscg_ReplacedBy_Model_Product extends Mage_Catalog_Model_Product
{

    protected function _construct()
    {
        parent::_construct();
    }

    /**
     * Retrieve array of replaced products
     *
     * @return array
     */
    public function getReplacedProducts()
    {
        if (!$this->hasReplacedProducts()) {
            $products = array();
            $collection = $this->getReplacedProductCollection();
            foreach ($collection as $product) {
                $products[] = $product;
            }
            $this->setReplacedProducts($products);
        }
        return $this->getData('replaced_products');
    }

    /**
     * Retrieve replaced products identifiers
     *
     * @return array
     */
    public function getReplacedProductIds()
    {
        if (!$this->hasReplacedProductIds()) {
            $ids = array();
            foreach ($this->getReplacedProducts() as $product) {
                $ids[] = $product->getId();
            }
            $this->setReplacedProductIds($ids);
        }
        return $this->getData('replaced_product_ids');
    }

    /**
     * Retrieve collection replaced product
     *
     * @return mixed
     */
    public function getReplacedProductCollection()
    {
        $collection = $this->getLinkInstance()->useReplacedLinks()
            ->getProductCollection()
            ->setIsStrongMode();
        $collection->setProduct($this);
        return $collection;
    }

    /**
     * Retrieve collection cables link
     *
     * @return mixed
     */
    public function getReplacedLinkCollection()
    {
        $collection = $this->getLinkInstance()->useReplacedLinks()
            ->getLinkCollection();
        $collection->setProduct($this);
        $collection->addLinkTypeIdFilter();
        $collection->addProductIdFilter();
        $collection->joinAttributes();
        return $collection;
    }

    public function duplicate()
    {
        $newProduct = parent::duplicate();

        /* Prepare Replaced */
        $data = array();
        $this->getLinkInstance()->useReplacedLinks();
        $attributes = array();
        foreach ($this->getLinkInstance()->getAttributes() as $_attribute) {
            if (isset($_attribute['code'])) {
                $attributes[] = $_attribute['code'];
            }
        }
        foreach ($this->getReplacedLinkCollection() as $_link) {
            $data[$_link->getLinkedProductId()] = $_link->toArray($attributes);
        }
        $newProduct->setReplacedLinkData($data);

        return($newProduct);
    }
}

?>