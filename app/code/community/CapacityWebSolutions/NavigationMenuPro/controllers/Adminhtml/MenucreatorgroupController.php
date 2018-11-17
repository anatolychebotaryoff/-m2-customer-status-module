<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Adminhtml_MenucreatorgroupController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('cws')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		return $this;
	}   
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}
	
	public function editAction() {
	$this->_initAction();
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('navigationmenupro/menucreatorgroup')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('menucreatorgroup_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('cws');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit'))
				->_addLeft($this->getLayout()->createBlock('navigationmenupro/adminhtml_menucreatorgroup_edit_tabs'));
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('navigationmenupro')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
		
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
			$model = Mage::getModel('navigationmenupro/menucreatorgroup');	
		
			
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}	
				/*$model->setPosition("2");
				*/
				$model->setDescription("This is descriptions");
				if(isset($data['alignment']))
				{
				$model->setAlignment($data['alignment']);
				}
				
				
				$model->save();
				/*Start Working to  Create & Update the Dynamic Css file for the menu items*/
				if($this->getRequest()->getParam('id') == "")
				{
				$group_id = $model->getData('group_id');
				}else
				{
				$group_id = $this->getRequest()->getParam('id');
				}
				
				 $current_theme = Mage::getSingleton('core/design_package')->getTheme('frontend');
			
				if (!file_exists(Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'navigationmenupro')) {
					mkdir(Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'navigationmenupro', 0777, true);
				}
				$path = Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'navigationmenupro'.DS;
				$path .= "group-".$group_id.".css";
				$css = $this->get_menu_css($group_id);
				file_put_contents($path,$css);
				/*End Working to  Create & Update the Dynamic Css file for the menu items*/
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('navigationmenupro')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('navigationmenupro')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
		
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('navigationmenupro/menucreatorgroup');
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
				/* Delete the css file from the directory*/
			
			
				$group_id = $this->getRequest()->getParam('id');
				$path = Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'navigationmenupro'.DS;
				$path .= "group-".$group_id.".css";
				
				if(is_file($path))
				{
				unlink($path);
				}
				/* Delete Css File Code Complete*/
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $menucreatorgroupIds = $this->getRequest()->getParam('navigationmenupro');
     
		if(!is_array($menucreatorgroupIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
			/* Delete the css file from the directory*/
				foreach ($menucreatorgroupIds as $menucreatorgroupId) {
                    $menucreatorgroup = Mage::getModel('navigationmenupro/menucreatorgroup')->load($menucreatorgroupId);
                    $menucreatorgroup->delete();
					$group_id = $menucreatorgroupId;
				
				$path = Mage::getBaseDir('skin').DS.'frontend'.DS.'base'.DS.'default'.DS.'css'.DS.'navigationmenupro'.DS;
				$path .= "group-".$group_id.".css";
				
				if(is_file($path))
				{
				unlink($path);
				}
				/* Delete Css File Code Complete*/
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($menucreatorgroupIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
		$delivered_status = (int) $this->getRequest()->getPost('status');
		$menucreatorgroupIds = $this->getRequest()->getParam('navigationmenupro');
        if(!is_array($menucreatorgroupIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($menucreatorgroupIds as $menucreatorgroupId) {
                    $menucreatorgroup = Mage::getSingleton('navigationmenupro/menucreatorgroup')
                        ->load($menucreatorgroupId)
                        ->setStatus($delivered_status)
                        ->save();
                }
				
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d group(s) status were successfully updated', count($menucreatorgroupIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	public function massLevelAction()
    {
		$delivered_level = (int)$this->getRequest()->getPost('level')-1;
		$menucreatorgroupIds = $this->getRequest()->getParam('navigationmenupro');
        if(!is_array($menucreatorgroupIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($menucreatorgroupIds as $menucreatorgroupId) {
                    $menucreatorgroup = Mage::getSingleton('navigationmenupro/menucreatorgroup')
                        ->load($menucreatorgroupId)
                        ->setLevel($delivered_level)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d groups(s) menu level were successfully updated', count($menucreatorgroupIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
	public function get_menu_css($group_id)
	{
	$groupdata = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	$alignment = $groupdata->getPosition();
	$menutype = $groupdata->getMenutype();
	$grouptitletextcolor = $groupdata->getTitletextcolor();
	$grouptitlebgcolor = $groupdata->getTitlebackcolor();
	$itemimageheight = $groupdata->getImageHeight();
	$itemimagewidth = $groupdata->getImageWidth();
	
	$textcolor = $groupdata->getItemtextcolor();
	$texthovercolor = $groupdata->getItemtexthovercolor();
	$textactivecolor = $groupdata->getrootactivecolor();
	$itembgcolor = $groupdata->getItembgcolor();
	$itembghovercolor = $groupdata->getItembghovercolor();
	$arrowcolor = $groupdata->getArrowcolor();
	$dividercolor = $groupdata->getDividercolor();
	$menu_bg_color = $groupdata->getMenubgcolor();
	$drop_bg_color = $groupdata->getSubitemsbgcolor();
	$drop_border_color = $groupdata->getSubitemsbordercolor();
	$megaparenttextcolor = $groupdata->getMegaparenttextcolor();
	$megaparenttexthovercolor = $groupdata->getMegaparenttexthovercolor();
	$megaparenttextactivecolor = $groupdata->getMegaparenttextactivecolor();
	$megaparenttextbgcolor = $groupdata->getMegaparenttextbgcolor();
	$megaparenttextbghovercolor = $groupdata->getMegaparenttextbghovercolor();
	$subitemtextcolor = $groupdata->getSubitemtextcolor();
	$subitemtexthovercolor = $groupdata->getSubitemtexthovercolor();
	$itemactivecolor = $groupdata->getItemactivecolor();
	$subitembgcolor = $groupdata->getSubitembgcolor();
	$subitembghovercolor = $groupdata->getSubitembghovercolor();
	$subarrowcolor = $groupdata->getSubarrowcolor();
	$subdividercolor = $groupdata->getSubitemdividercolor();
	
	
	$css = '';
	// Common class
	$css .= '#cwsMenu-'.$group_id.' { background-color:#'.$menu_bg_color.'; }';
	$css .= '#cwsMenu-'.$group_id.' .menuTitle { color:#'.$grouptitletextcolor.'; background-color:#'.$grouptitlebgcolor.'; }';
	$css .= '#cwsMenu-'.$group_id.' ul.cwsMenu span.img { max-height:'.$itemimageheight.'px; max-width:'.$itemimagewidth.'px; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.horizontal > li.parent > a:after { border-top-color:#'.$arrowcolor.'; }'; // Horizontal
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.vertical > li.parent > a:after { border-left-color:#'.$arrowcolor.'; }'; // Verticle
	
	// First lavel
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.Level0 > a { color:#'.$textcolor.'; background-color:#'.$itembgcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.mega-menu li.Level0:hover > a { color:#'.$texthovercolor.'; background-color:#'.$itembghovercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.smart-expand li.Level0 > a:hover,';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.always-expand li.Level0 > a:hover { color:#'.$texthovercolor.'; background-color:#'.$itembghovercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.Level0.active > a { color:#'.$textactivecolor.'; }';

	$css .='#cwsMenu-'.$group_id.' .cwsMenu.horizontal > li.parent > a:after { border-top-color:#'.$arrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.horizontal > li { border-right-color:#'.$dividercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.vertical > li { border-top-color:#'.$dividercolor.'; }';
	
	#cwsMenu-1 ul.cwsMenu li.hideTitle li a.Level2 { color:#83b925; font-weight:bold; font-size: 12px; }*/
	
	// Second lavel
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li > ul.subMenu { background-color:#'.$drop_bg_color.'; border-color:#'.$drop_border_color.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li li > a { color:#'.$subitemtextcolor.'; background-color:#'.$subitembgcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.mega-menu li li:hover > a { color:#'.$subitemtexthovercolor.'; background-color:#'.$subitembghovercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li li.active > a { color:#'.$itemactivecolor.'; }';

	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.mega-menu li.column-1 li.parent > a:after { border-left-color:#'.$subarrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.'.rtl ul.cwsMenu.mega-menu li.column-1 li.parent > a:after { border-right-color:#'.$subarrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.'.rtl .cwsMenu.vertical > li.parent.aRight > a:after { border-right-color:#'.$subarrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.'.rtl .cwsMenu.vertical li.column-1.aRight li.parent > a:after { border-right-color:#'.$subarrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li ul > li { border-bottom-color:#'.$subdividercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.vertical > li li { border-top-color:#'.$subdividercolor.'; }';
	
	// Megamenu column title Color
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.megamenu ul li.Level1 > a { color:#'.$megaparenttextcolor.'; background-color:#'.$megaparenttextbgcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.megamenu ul li.Level1:hover > a { color:#'.$megaparenttexthovercolor.'; background-color:#'.$megaparenttextbghovercolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.megamenu li.Level1 ul.Level1 > li { border-bottom-color:#'.$subdividercolor.'; }';
	
	// Megamenu column When hide title of column
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.megamenu ul li.hideTitle li.Level2 > a { color:#'.$megaparenttextcolor.'; background-color:#'.$megaparenttextbgcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu li.megamenu ul li.hideTitle li.Level2:hover > a { color:#'.$megaparenttexthovercolor.'; background-color:#'.$megaparenttextbghovercolor.'; }';
	
	// Smart/Always Expand Color
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.smart-expand li > span.arw { color:#'.$arrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.smart-expand > li,';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.always-expand > li { border-top-color:#'.$dividercolor.'; }';
	
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.smart-expand li li > span.arw { color:#'.$subarrowcolor.'; }';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.smart-expand > li li,';
	$css .='#cwsMenu-'.$group_id.' .cwsMenu.always-expand > li li { border-top-color:#'.$subdividercolor.'; }';
	
	$css .='#cwsMenu-'.$group_id.' ul.cwsMenu.always-expand li li a:hover { color:#'.$subitemtexthovercolor.'; background-color:#'.$subitembghovercolor.'; }';
	
	
	return $css;
	}
	public function _isAllowed()
	{
			return true;
	}
	
}