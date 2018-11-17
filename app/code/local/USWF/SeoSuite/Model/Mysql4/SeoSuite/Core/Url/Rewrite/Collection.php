<?php

class USWF_SeoSuite_Model_Mysql4_SeoSuite_Core_Url_Rewrite_Collection extends MageWorx_SeoSuite_Model_Mysql4_Core_Url_Rewrite_Collection
{

    /**
     * Fixed show data in Magento admin (Canonical URL).
     *
     * @param int $productId
     * @param bool|false $useCategories
     * @return $this
     */
    public function filterAllByProductId($productId, $useCategories = false)
    {
        if ($productId != null) {
            if ($useCategories == 1) {
                // longest
                $this->getSelect()->where('product_id = ? AND category_id is not null AND is_system = 1', $productId,
                    Zend_Db::INT_TYPE);
                $this->sortByLength('DESC');
            }
            else if ($useCategories == 2) {
                // shortest
                $this->getSelect()->where('product_id = ? AND category_id is not null AND is_system = 1', $productId,
                    Zend_Db::INT_TYPE);
                $this->sortByLength('ASC');
            }
            else {
                // root or other
                $this->getSelect()->where('product_id = ? AND is_system = 0', $productId, Zend_Db::INT_TYPE);
            }
        }

        return $this;
    }

}