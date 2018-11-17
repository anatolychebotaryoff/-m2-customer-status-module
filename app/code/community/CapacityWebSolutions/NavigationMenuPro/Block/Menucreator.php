<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/ 
class CapacityWebSolutions_NavigationMenuPro_Block_Menucreator extends Mage_Core_Block_Template {
	protected $group_option = '';	
	public function _prepareLayout() 
	{	
		return parent::_prepareLayout();
    }
	public function getMenutype($group_id)
	{
	$group_details = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	$group_menutype = trim($group_details->getMenutype());
	return $group_menutype;
	}
	public function get_menu_items($group_id) {
	$this->group_option = '';
	$group_details = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	if($group_details->getStatus() == "1"){
		
		/* Here set the group Position of the group*/
		$group_position = $group_details->getPosition();
		$group_menutype = $group_details->getMenutype();
		if(($group_menutype == 'mega-menu'))
		{
		$this->group_option = $group_menutype." ".$group_position;
		}else
		{
		$this->group_option = $group_menutype;
		}
		
		/* Check Menu Title Display Or not*/
		
		$group_level = $group_details->getLevel();
		$direction = $group_details->getDirection();
		$direction = $group_details->getDirection();
		if($direction=='rtl'){
			$direction_css = 'rtl';
		}elseif($direction=='ltr'){
			$direction_css = 'ltr';
		}
		if($group_menutype == 'list-item') {
			
			if($direction_css!=''){
					$menufront = "<nav id='cwsMenu-".$group_id."' class='".$direction_css."'>";
				}else{
					$menufront = "<nav id='cwsMenu-".$group_id."'>";
				}
		} else {
				if($direction_css!=''){
					$menufront = "<nav id='cwsMenu-".$group_id."' class='cwsMenuOuter ".$direction_css." '>";		
				}else{
					$menufront = "<nav id='cwsMenu-".$group_id."' class='cwsMenuOuter'>";
				}
			
		}
		

			if($group_details->getShowhidetitle() == "2"){
				$menufront .= '<h3 class="menuTitle">'.$group_details->getTitle().'</h3>';
			}
			if($group_menutype != 'list-item'){
				$menufront .="<ul class='cwsMenu ".$this->group_option."'>";
			} else {
				$menufront .="<ul>";
			}
			$menufront .= Mage::getModel("navigationmenupro/menuitem")->getMenuContent($group_id);
			$menufront .= "</ul>";
			$menufront .= "</nav>";
			return $menufront;
		
		} else {
			return;
		}
	
	}
	public function get_menu_css($group_id) {
	Mage::app()->getLayout()->getBlock('head')->addJs('js/path/here.js');

	$groupdata = Mage::getModel("navigationmenupro/menucreatorgroup")->load($group_id);
	$alignment = $groupdata->getPosition();
	$menutype = $groupdata->getMenutype();
	$grouptitletextcolor = $groupdata->getTitletextcolor();
	$grouptitlebgcolor = $groupdata->getTitlebackcolor();
	$textcolor = $groupdata->getItemtextcolor();
	$texthovercolor = $groupdata->getItemtexthovercolor();
	$itembgcolor = $groupdata->getItembgcolor();
	$itembghovercolor = $groupdata->getItembghovercolor();
	$css = '';
	$css .='#menu-'.$group_id.' ul.cwsMenu.'.$alignment.' li { background-color:#'.$itembgcolor.'}';
	$css .='#menu-'.$group_id.' ul.cwsMenu.'.$alignment.' li:hover { background-color:#'.$itembghovercolor.'}';
	$css .='#menu-'.$group_id.' ul.cwsMenu.'.$alignment.' li a { color:#'.$textcolor.'}';
	$css .='#menu-'.$group_id.' ul.cwsMenu.'.$alignment.' li a:hover { color:#'.$texthovercolor.'}';
	return $css;
	}
	
	public function setCssJs($value) {
	
	$head = $this->getLayout()->getBlock('head')->addCss('css/navigationmenupro/group-'.$value.'.css');
	$head->addCss('css/navigationmenupro/group-'.$value.'.css');
		
	}
	public function __getHeadBlock() {
		return Mage::getSingleton('core/layout')->getBlock('navigationmenupro_head');
	}
	
}