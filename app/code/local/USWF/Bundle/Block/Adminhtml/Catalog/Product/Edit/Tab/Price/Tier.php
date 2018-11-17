<?php
/**
 * Tier.php
 *
 * @category    USWF
 * @package     USWF_Bundle
 * @copyright
 * @author
 */

class USWF_Bundle_Block_Adminhtml_Catalog_Product_Edit_Tab_Price_Tier
    extends Mage_Adminhtml_Block_Catalog_Product_Edit_Tab_Price_Tier
{

    /**
     * Initialize block
     */
    public function __construct()
    {
        $this->setTemplate('catalog/product/edit/price/bundle/tier.phtml');
    }
}
