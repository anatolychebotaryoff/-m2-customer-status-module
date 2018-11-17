<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'navigationmenupro';
        $this->_controller = 'adminhtml_menucreatorgroup';
        $this->_updateButton('save', 'label', Mage::helper('navigationmenupro')->__('Save Group'));
        $this->_updateButton('delete', 'label', Mage::helper('navigationmenupro')->__('Delete Group'));
		 $this->_addButton('saveandcontinue', array(
            'label' => Mage::helper('adminhtml')->__('Save Group And Continue Edit'),
            'onclick' => 'saveAndContinueEdit()',
            'class' => 'save',
            ), -100);
        
        $this->_formScripts[] = "
            function toggleEditor() {
                if (tinyMCE.getInstanceById('menucreatorgroup_comment') == null) {
                    tinyMCE.execCommand('mceAddControl', false, 'menucreatorgroup_comment');
                } else {
                    tinyMCE.execCommand('mceRemoveControl', false, 'menucreatorgroup_comment');
                }
            }

            function saveAndContinueEdit(){
                editForm.submit($('edit_form').action+'back/edit/');
            }
			
        ";
	}

    public function getHeaderText()
    {	
		if( Mage::registry('menucreatorgroup_data') && Mage::registry('menucreatorgroup_data')->getGroupId() ) {
            return Mage::helper('navigationmenupro')->__("Edit Group '%s' Information", $this->htmlEscape(Mage::registry('menucreatorgroup_data')->getTitle()));
        } else {
            return Mage::helper('navigationmenupro')->__('Add Group');
        }
    }
}