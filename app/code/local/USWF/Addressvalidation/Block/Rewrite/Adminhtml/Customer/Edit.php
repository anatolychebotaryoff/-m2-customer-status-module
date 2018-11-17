<?php
/**
 * Customer edit block
 * fix bug: address without state isn't saved in backend by admin in customer profile
 * @category
 * @package
 * @author
 */

class USWF_Addressvalidation_Block_Rewrite_Adminhtml_Customer_Edit  extends QS_Addressvalidation_Block_Rewrite_Adminhtml_Customer_Edit
{

    public function __construct() {
        parent::__construct();
        $this->setTemplate('uswf/addressvalidation/widget/form/container.phtml');
    }

}