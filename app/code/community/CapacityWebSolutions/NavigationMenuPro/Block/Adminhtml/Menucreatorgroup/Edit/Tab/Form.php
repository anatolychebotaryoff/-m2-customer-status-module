<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Adminhtml_Menucreatorgroup_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
        $fieldset = $form->addFieldset('groupmenu_form', array('legend' => Mage::helper('navigationmenupro')->__('Group Information')));
        
        $fieldset->addField('title', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Title'),
            'class' => 'required-entry',
            'required' => true,
            'name' => 'title',
        ));
		
		
         $fieldset->addField('status', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Status'),
            'name' => 'status',
            'values' => Mage::getModel('navigationmenupro/status')->getOptionArray() 
        ));
		
		 $fieldset->addField('showhidetitle', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Show Hide Group Title'),
			 'class' => 'required-entry',
            'required' => true,
            'name' => 'showhidetitle',
			'values' => Mage::helper('navigationmenupro')->getShowHideTitle() 
        )); 
		
		$menu_type = $fieldset->addField('menutype', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Menu Type'),
			'class' => 'required-entry',
            'required' => true,
            'name' => 'menutype',
            'values' => Mage::helper('navigationmenupro')->getGroupMenuType() 
        ));
		
		$position = $fieldset->addField('position', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Alignment'),
            'name' => 'position',
			'class' => 'required-entry',
            'required' => true,
            'values' => array(
                array(
                    'value' => '',
                    'label' => Mage::helper('navigationmenupro')->__('Please Select Alignment'),
                ),
                
				array(
                    'value' => 'horizontal',
                    'label' => Mage::helper('navigationmenupro')->__('Horizontal'),
                ),
                array(
                    'value' => 'vertical',
                    'label' => Mage::helper('navigationmenupro')->__('Vertical'),
                ),
            ),
        ));
		$dropdownlevel = $fieldset->addField('level', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Item Level'),
			'class' => 'required-entry',
            'required' => true,
			'name' => 'level',
            'values' => Mage::helper('navigationmenupro')->getMenuLevel() 
        ));
		$fieldset->addField('direction', 'select', array(
            'label' => Mage::helper('navigationmenupro')->__('Direction'),
			'class' => 'required-entry',
            'required' => true,
			'name' => 'direction',
            'values' => Mage::helper('navigationmenupro')->getDirection() 
        ));
		$fieldset->addField('image_height', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Image height'),
            'class' => 'required-entry validate-number',
            'name' => 'image_height',
			'required' => true,
			'after_element_html' => '<small>Image height set in px</small>',
        ));
		$fieldset->addField('image_width', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Image width'),
            'class' => 'required-entry validate-number',
            'name' => 'image_width',
			'required' => true,
			'after_element_html' => '<small>Image width set in px</small>',
        ));
		$fieldset = $form->addFieldset('groupmenu_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Root Menu Links Settings')));
		
		/* Do not Change the Class Name Color For the Below Text Box it will use to display the color picker*/
		
		$fieldset->addField('titletextcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Title Color'),
			'name' => 'titletextcolor',
			'class' => 'color {required:false}',
		));

		$fieldset->addField('titlebackcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Title Background Color'),
			'name' => 'titlebackcolor',
			'class' => 'color {required:false}',
		));
		$fieldset->addField('menubgcolor', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Menu Background Color'),
			'name' => 'menubgcolor',
			'class' => 'color {required:false}',
        ));
		
		$fieldset->addField('itemtextcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Color'),
			'name' => 'itemtextcolor',
			'class' => 'color {required:false}',
		));

		$fieldset->addField('itemtexthovercolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Hover Color'),
			'name' => 'itemtexthovercolor',
			'class' => 'color {required:false}',
		));
		
		$fieldset->addField('rootactivecolor', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Link Active Color'),
			'name' => 'rootactivecolor',
			'class' => 'color {required:false}',
        ));

		$fieldset->addField('itembgcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Background Color'),
			'name' => 'itembgcolor',
			'class' => 'color {required:false}',
		));

		$fieldset->addField('itembghovercolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Hover Background Color'),
			'name' => 'itembghovercolor',
			'class' => 'color {required:false}',
		));
		
		$fieldset->addField('arrowcolor', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Arrow Color'),
			'name' => 'arrowcolor',
			'class' => 'color {required:false}',
        ));
		
		$fieldset->addField('dividercolor', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Divider Color'),
			'name' => 'dividercolor',
			'class' => 'color {required:false}',
        ));
		
		$fieldset = $form->addFieldset('dropdown_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Dropdown Menu Color Setings')));
		
		$fieldset->addField('subitemsbgcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Dropdown Box Color'),
			'name' => 'subitemsbgcolor',
			'class' => 'color {required:false}',
		));

		$fieldset->addField('subitemsbordercolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Dropdown Box Border Color'),
			'name' => 'subitemsbordercolor',
			'class' => 'color {required:false}',
		));
		
		$fieldset = $form->addFieldset('megaparent_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Mega Menu Column Title Color Setings')));
		
		$fieldset->addField('megaparenttextcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Color'),
			'name' => 'megaparenttextcolor',
			'class' => 'color {required:false}',
		));

		$fieldset->addField('megaparenttexthovercolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Hover Color'),
			'name' => 'megaparenttexthovercolor',
			'class' => 'color {required:false}',
		));

		$fieldset->addField('megaparenttextactivecolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Active Color'),
			'name' => 'megaparenttextactivecolor',
			'class' => 'color {required:false}',
		));

		$fieldset->addField('megaparenttextbgcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Background Color'),
			'name' => 'megaparenttextbgcolor',
			'class' => 'color {required:false}',
		));

		$fieldset->addField('megaparenttextbghovercolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Background Hover Color'),
			'name' => 'megaparenttextbghovercolor',
			'class' => 'color {required:false}',
		));

		$fieldset = $form->addFieldset('subitems_form_color', array('legend' => Mage::helper('navigationmenupro')->__('Sub Menu Links Color Settings')));
	
		$fieldset->addField('subitemtextcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Color'),
			'name' => 'subitemtextcolor',
			'class' => 'color {required:false}',
		));

		$fieldset->addField('subitemtexthovercolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Hover Color'),
			'name' => 'subitemtexthovercolor',
			'class' => 'color {required:false}',
		));
		
		$fieldset->addField('itemactivecolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Active Color'),
			'name' => 'itemactivecolor',
			'class' => 'color {required:false}',
		));
		
		$fieldset->addField('subitembgcolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Background Color'),
			'name' => 'subitembgcolor',
			'class' => 'color {required:false}',
		));
		
		$fieldset->addField('subitembghovercolor','text',array(
			'label' => Mage::helper('navigationmenupro')->__('Link Background Hover Color'),
			'name' => 'subitembghovercolor',
			'class' => 'color {required:false}',
		));
		
		$fieldset->addField('subarrowcolor', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Arrow Color'),
			'name' => 'subarrowcolor',
			'class' => 'color {required:false}',
        ));
		
		$fieldset->addField('subitemdividercolor', 'text', array(
            'label' => Mage::helper('navigationmenupro')->__('Sub Divider Color'),
			'name' => 'subitemdividercolor',
			'class' => 'color {required:false}',
        ));
		 
		/*itemtextcolor*/
		 if ( Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData());
		  $data = Mage::getSingleton('adminhtml/session')->getMenucreatorgroupData();
          Mage::getSingleton('adminhtml/session')->setMenucreatorgroupData(null);
      } elseif ( Mage::registry('menucreatorgroup_data') ) {
          $form->setValues(Mage::registry('menucreatorgroup_data')->getData());
		  $data = Mage::registry('menucreatorgroup_data')->getData();
      }
	  /* Set Default Value in the group form.*/
	  $id = $this->getRequest()->getParam('id');
	  if((empty($data)) && ($id == ''))
	  {
	  $data['image_height'] = '25';
	  $data['image_width'] = '25';
	  $data['level'] = '5';
	  $data['titletextcolor'] = '160E47';
	  $data['titlebackcolor'] = 'A0BD2B';
	  $data['itemtextcolor'] = '444444';
	  $data['itemtexthovercolor'] = 'FFFFFF';
	  $data['menubgcolor'] = 'FFFFFF';
	  $data['itembgcolor'] = 'EEEEEE';
	  $data['itembghovercolor'] = '333333';
	  $data['arrowcolor'] = '666666';
	   $data['rootactivecolor'] = 'FF0000';
	  $data['subitemsbgcolor'] = '666666';
	  $data['subitemsbordercolor'] = '333333';
	  $data['megaparenttextcolor'] = 'FFFFFF';
	  $data['megaparenttexthovercolor'] = 'FFFFFF';
	  $data['megaparenttextactivecolor'] = 'FFDD00';
	  $data['megaparenttextbgcolor'] = '333333';
	  $data['megaparenttextbghovercolor'] = '000000';
	  $data['subitemtextcolor'] = 'FFFFFF';
	  $data['subitemtexthovercolor'] = 'FFFFFF';
	  $data['itemactivecolor'] = 'FF0000';
	  $data['subitembgcolor'] = '555555';
	  $data['subitembghovercolor'] = '333333';
	  $data['subitemdividercolor'] = 'A6A6A6';
	  $data['dividercolor'] = 'CCCCCC';
	  $data['subarrowcolor'] = 'A6A6A6';
	  }
	   $form->setValues($data);
	    $this->setForm($form);
        $this->setChild('form_after', $this->getLayout()->createBlock('adminhtml/widget_form_element_dependence')
            ->addFieldMap($menu_type->getHtmlId(), $menu_type->getName())
			->addFieldMap($position->getHtmlId(), $position->getName())
			->addFieldDependence(
                $position->getName(),
				$menu_type->getName(),
				'mega-menu'
            )
			
        );	 
        return parent::_prepareForm();
  }
  
}