<?php
/**
 * Rewrite Controller for JR_AttributeOptionImage_Cms_Wysiwyg_ImagesController
 *
 * @category   Lyons
 * @package    Lyonscg_AttributeOptionImage
 * @copyright  Copyright (c) 2014 Lyons Consulting Group (www.lyonscg.com)
 * @author     Mark Hodge (mhodge@lyonscg.com)
 */
require_once 'JR/AttributeOptionImage/controllers/Cms/Wysiwyg/ImagesController.php';

class Lyonscg_AttributeOptionImage_Adminhtml_Cms_Wysiwyg_ImagesController extends JR_AttributeOptionImage_Cms_Wysiwyg_ImagesController
{
    /**
     * Set as_is param to true to allow <img src="{{media url=""}}" /> links
     */
    public function onInsertAction()
    {
        $this->getRequest()->setParam('as_is', true);
        Mage_Adminhtml_Cms_Wysiwyg_ImagesController::onInsertAction();
        $this->_getSession()->setStaticUrlsAllowed();
    }
}