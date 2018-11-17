<?php
/***************************************************************************
 Extension Name	: Magento Navigation Menu Pro - Responsive Mega Menu / Accordion Menu / Smart Expand Menu
 Extension URL	: http://www.magebees.com/magento-navigation-menu-pro-responsive-mega-menu-accordion-menu-smart-expand.html
 Copyright		: Copyright (c) 2015 MageBees, http://www.magebees.com
 Support Email	: support@magebees.com 
 ***************************************************************************/
class CapacityWebSolutions_NavigationMenuPro_Model_Menucreator extends Mage_Core_Model_Abstract {	
	protected $parentitems = array();
	protected $optionData = "";
	protected $category_list = array();
	protected $child_menu_items = array();
	
	public function _construct()
    {
        parent::_construct();
        $this->_init('navigationmenupro/menucreator');
    }
	public function getMenuGroup()
	{
		return Mage::getModel('navigationmenupro/menucreator')->getCollection()->addFieldToSelect('group_id')->distinct(true);
		}
	public function getMenuitem()
    {
    	$menu_items=Mage::getModel('navigationmenupro/menucreator')->getCollection()->setOrder("group_id","asc")->setOrder("position","asc");
    	return $menu_items;
    }
	public function getChildMenuCollection ($parentId)
    {
    	$chilMenu= Mage::getModel('navigationmenupro/menucreator')->getCollection()->setOrder("position","asc");
    	
        $chilMenu->addFieldToFilter('parent_id',$parentId);
        return $chilMenu;
    }
	public function getchild($parentID)
	{
		
		$childCollection=$this->getChildMenuCollection($parentID);
		foreach($childCollection as $value){
			$menuId = $value->getMenuId();
			//Check this menu has child or not
			$this->optionData = Mage::helper("navigationmenupro")->getMenuSpace($menuId);
			$this->parentoption[$menuId] = array('title' => '----' . $this->optionData['blank_space'] . $value->getTitle(), 'group_id' => $value->getGroupId(), 'level' => $this->optionData['level']);
			$hasChild = $this->getChildMenuCollection($menuId);
			if(count($hasChild)>0)
			{
				$this->getchild($menuId);
			}
		}
	}
	
	public function getNewFileName($destFile)
    {
        $fileInfo = pathinfo($destFile);
        if (file_exists($destFile)) {
            $index = 1;
            $baseName = $fileInfo['filename'] . '.' . $fileInfo['extension'];
            while( file_exists($fileInfo['dirname'] . DIRECTORY_SEPARATOR . $baseName) ) {
                $baseName = $fileInfo['filename']. '_' . $index . '.' . $fileInfo['extension'];
                $index ++;
            }
            $destFileName = $baseName;
        } else {
            return $fileInfo['basename'];
        }

        return $destFileName;
    }
	function getCategorieslistform($parentId, $isChild){
    $allCats = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToSelect('*')
				->addAttributeToFilter('include_in_menu', array('eq' => 1))
				->addAttributeToFilter('is_active', array('eq' => 1))					
                ->addAttributeToFilter('parent_id',array('eq' => $parentId))
                ->addAttributeToSort('position', 'asc');
               
    $class = ($isChild) ? "sub-cat-list" : "cat-list";
    
    foreach($allCats as $category)
    {
		$lable = '';
	if($category->getLevel() > 2)
	{	$lable = '';
		for($i=2;$i<=$category->getLevel();$i++)
		{
		$lable .= "\t".' -';
		}
	}
	$lable = ($lable) ? $lable : "";
	$html = isset($html) ? $html : "";
	?>
	
<?php 	$this->category_list[] = array(
                    'value' => $category->getId(),
                    'label' => $lable . " ".$category->getName(),
                );
    	if($class == "sub-cat-list")
		{
		$html .= '<option value="'.$category->getId().'">'.$lable." ".$category->getName().' </option>';
		}else if($class == "cat-list")
		{
		$html .= '<option value="'.$category->getId().'">'.$lable." ".$category->getName().'</option>';
		}
		   /*Remove Ul & Li End*/         
    	 $lable = '';
		$subcats = $category->getChildren();
        if($subcats != ''){
            $html .= $this->getCategorieslistform($category->getId(), true);
        }
    
    }
	return $this->category_list;
    //return $html;
}
	function getCategorieslist($parentId, $isChild){
    $allCats = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('parent_id',array('eq' => $parentId))
                ->addAttributeToSort('position', 'asc');
              
    $class = ($isChild) ? "sub-cat-list" : "cat-list";
    $html = isset($html) ? $html : '';
    foreach($allCats as $category)
    {
	if($category->getLevel() > 2)
	{	$lable = '';
		for($i=2;$i<=$category->getLevel();$i++)
		{
		$lable .= "\t".' -';
		}
	}else
	{
	$lable = '';
	}
	
	?>
	
<?php 
		
    	if($class == "sub-cat-list")
		{
		$html .= '<option value="'.$category->getId().'">'.$lable." ".$category->getName().' </option>';
		}else if($class == "cat-list")
		{
		$html .= '<option value="'.$category->getId().'">'.$lable." ".$category->getName().'</option>';
		}
		   /*Remove Ul & Li End*/         
    	 $lable = '';
		$subcats = $category->getChildren();
        if($subcats != ''){
            $html .= $this->getCategorieslist($category->getId(), true);
        }
    
    }
    return $html;
}

/*Display All the Parent Items On the Form Parent Item Drop Down*/
public function getParentItems($group_id,$current_menu_id){
	$cur_menu_id = $current_menu_id;
	$allParent = Mage::getModel('navigationmenupro/menucreator')->getCollection()
                ->addFieldToFilter('parent_id',"0")
				->setOrder("position","asc")
				->addFieldToFilter('group_id',$group_id);
	$html = isset($html) ? $html : '';
	/* Use Current_menu_id to select the current Parent Element when the page is load for the edit the menu items*/
	$Currentmenu = Mage::getModel('navigationmenupro/menucreator')->load($current_menu_id);
	$current_parent_item = $Currentmenu->getParentId();
	if($current_parent_item == "0")
	{
	$html = '<option value="">Please Select Parent</option><option value="0" selected>Root</option>';
	}else{
	$html = '<option value="">Please Select Parent</option><option value="0">Root</option>';
	}
	foreach($allParent as $item)
    {
	$space = Mage::helper("navigationmenupro")->getMenuSpace($item->getMenuId());
	if($cur_menu_id != $item->getMenuId())
	{
		if($current_parent_item == $item->getMenuId())
		{
			$html .= '<option value="'.$item->getMenuId().'" selected>'.$space.$item->getTitle().' </option>';
		}else
		{
			$html .= '<option value="'.$item->getMenuId().'">'.$space.$item->getTitle().' </option>';
		}
	
	}
	
	$hasChild = $this->getChildMenuCollection($item->getMenuId());
	if(count($hasChild)>0)
	{
	$html .= $this->getChildlist($item->getMenuId(),true,$cur_menu_id);
	}
	}
return $html;
}
function getChildlist($parentId, $isChild,$cur_menu_id){
$allChild = Mage::getModel('navigationmenupro/menucreator')->getCollection()
				->setOrder("position","asc")
                ->addFieldToFilter('parent_id',$parentId);
	$Currentmenu = Mage::getModel('navigationmenupro/menucreator')->load($cur_menu_id);
	$current_parent_item = $Currentmenu->getParentId();
	
	$html = isset($html) ? $html : '';		
	foreach($allChild as $item)
    {
	$space = Mage::helper("navigationmenupro")->getMenuSpace($item->getMenuId());
	if($cur_menu_id != $item->getMenuId())
	{
		if($current_parent_item == $item->getMenuId())
		{
			$html .= '<option value="'.$item->getMenuId().'" selected>'.$space.$item->getTitle().' </option>';
		}else
		{
			$html .= '<option value="'.$item->getMenuId().'">'.$space.$item->getTitle().'</option>';
		}
	
	}
	$hasChild = $this->getChildMenuCollection($item->getMenuId());
	if(count($hasChild)>0)
	{
	$html .= $this->getChildlist($item->getMenuId(),true,$cur_menu_id);
	}
	}
	return $html;
}
/*Here We use Another Function To Fatch the Parent Drop down value when we directly add the Sub Child of the Parent Items*/ 
public function getAddSubParentItems($group_id,$current_menu_id){
	$cur_menu_id = $current_menu_id;
	$allParent = Mage::getModel('navigationmenupro/menucreator')->getCollection()
                ->addFieldToFilter('parent_id',"0")
				->setOrder("position","asc")
				->addFieldToFilter('group_id',$group_id);
	
	$html = '<option value="">Please Select Parent</option><option value="0">Root</option>';
	
	foreach($allParent as $item)
    {
	$space = Mage::helper("navigationmenupro")->getMenuSpace($item->getMenuId());
	
		if($cur_menu_id == $item->getMenuId())
		{
			$html .= '<option value="'.$item->getMenuId().'" selected>'.$space.$item->getTitle().' </option>';
		}else
		{
			$html .= '<option value="'.$item->getMenuId().'">'.$space.$item->getTitle().' </option>';
		}
	
	$hasChild = $this->getChildMenuCollection($item->getMenuId());
	if(count($hasChild)>0)
	{
	$html .= $this->getAddSubChildlist($item->getMenuId(),true,$cur_menu_id);
	}
	}
return $html;
}
function getAddSubChildlist($parentId, $isChild,$cur_menu_id){
$allChild = Mage::getModel('navigationmenupro/menucreator')->getCollection()
				->setOrder("position","asc")
                ->addFieldToFilter('parent_id',$parentId);
	$Currentmenu = Mage::getModel('navigationmenupro/menucreator')->load($cur_menu_id);
	$current_parent_item = $Currentmenu->getParentId();
	$html = isset($html) ? $html : '';
				
	foreach($allChild as $item)
    {
	$space = Mage::helper("navigationmenupro")->getMenuSpace($item->getMenuId());
	
		if($cur_menu_id == $item->getMenuId())
		{
			$html .= '<option value="'.$item->getMenuId().'" selected>'.$space.$item->getTitle().' </option>';
		}else
		{
			$html .= '<option value="'.$item->getMenuId().'">'.$space.$item->getTitle().'</option>';
		}
	$hasChild = $this->getChildMenuCollection($item->getMenuId());
	if(count($hasChild)>0)
	{
	$html .= $this->getAddSubChildlist($item->getMenuId(),true,$cur_menu_id);
	}
	}
	return $html;
}
public function getMenuTree($group_id){
	$allParent = Mage::getModel('navigationmenupro/menucreator')->getCollection()
                ->addFieldToFilter('parent_id',"0")
				->setOrder("position","asc")
				/*->setOrder("created_time","asc")*/
				->addFieldToFilter('group_id',$group_id);
	$html = isset($html) ? $html : '';
	foreach($allParent as $item)
    {
	$url = Mage::helper("adminhtml")->getUrl("adminhtml/menucreator/edit/",array("id" => $item->getMenuId()));
	$add_sub_url = Mage::helper('adminhtml')->getUrl('adminhtml/menudata/addsubparent');
	$editformurl = Mage::helper("adminhtml")->getUrl("adminhtml/menucreator/editform/",array("id" => $item->getMenuId()));
	$add_sub = Mage::helper("adminhtml")->getUrl("adminhtml/menucreator/new/",array("group_id" => $item->getGroupId(),"parent_id" => $item->getMenuId()));
	$delete_url = Mage::helper("adminhtml")->getUrl("adminhtml/menucreator/deleteitems/",array("id" => $item->getMenuId()));
	$current_url = Mage::helper('core/url')->getCurrentUrl();
	$space = Mage::helper("navigationmenupro")->getMenuSpace($item->getMenuId());
	$hasChild = $this->getChildMenuCollection($item->getMenuId());
	$menu_type = trim($item->getType());
	if($item->getStatus()=="1")
	{
	$status = ' enabled';
	}else
	{
	$status = ' disabled';
	}
	if($item->getClassSubfix() != '')
	{
	$add_custom_class = $item->getClassSubfix();
	}else
	{
	$add_custom_class = '';
	}
	if(count($hasChild)>0) {
	$has_child_element = 'mjs-nestedSortable-branch mjs-nestedSortable-expanded ';
	}
	else
	{
	$has_child_element = 'mjs-nestedSortable-leaf ';
	}
	$column_layout = trim($item->getSubcolumnlayout());
	if(($column_layout == 'no-sub') && ($menu_type == "3"))
	{
	$html .= '<li class="'.$has_child_element.$status.' '.$add_custom_class.' no-sub" id="menuItem_'.$item->getMenuId().'" store="'.$item->getStoreids().'"> <div class="menuDiv">';
	}else if(($menu_type == "7")){
		$html .= '<li class="'.$has_child_element.$status.' '.$add_custom_class.' no-sub" id="menuItem_'.$item->getMenuId().'" store="'.$item->getStoreids().'"> <div class="menuDiv">';
	}else
	{
	$html .= '<li class="'.$has_child_element.$status.' '.$add_custom_class.'" id="menuItem_'.$item->getMenuId().'" store="'.$item->getStoreids().'"> <div class="menuDiv">';
	}
	
	if(count($hasChild)>0) {
	$html .= '<span class="disclose ui-icon ui-icon-minusthick" title="Click to show/hide children"><span></span></span>';
	}
	$html .= '<span class="itemTitle" data-id="'.$item->getMenuId().'">'.$item->getTitle().'</span>
	<button onclick=editform("'.$editformurl.'"); class="scalable edit" type="button" title="Edit '.$item->getTitle().'"><span>Edit Menu</span></button>
	<button onclick=addsub("'.$item->getGroupId().'","'.$item->getMenuId().'","'.$add_sub_url.'"); class="scalable add" type="button" title="Add in '.$item->getTitle().'"><span>Add Sub</span></button>
	<button onclick=deleteitem("'.$delete_url.'","'.$current_url.'"); class="scalable delete" type="button" title="Delete '.$item->getTitle().'"><span></span></button>
	</div>';
	 
	$has_child_element = '';
	$parent_status = '';
	$add_custom_class = '';
	/* Use TO Get The Sub Category If set Autoi Sub On when the menu type is category*/
	
	if(count($hasChild)>0)
	{
	$html .= $this->getTreeChild($item->getMenuId(),true,$column_layout,$menu_type);
	}
	
	
	$html .= '</li>';
	}
	
return $html;
}
function getTreeChild($parentId, $isChild,$column_layout,$menu_type){
$allChild = Mage::getModel('navigationmenupro/menucreator')->getCollection()
				->setOrder("position","asc")
				->addFieldToFilter('parent_id',$parentId);
	
	$html = isset($html) ? $html : '';
	$Parent_menu = Mage::getModel('navigationmenupro/menucreator')->load($parentId);
	if($Parent_menu->getStatus()=="1")
	{
	$parent_status = ' enabled';
	}else
	{
	$parent_status = ' disabled';
	}
	
	$class = ($isChild) ? "sub-cat-list" : "cat-list";
   
	if(($column_layout == 'no-sub'))
	{
	$html .= '<ol class="'.$class.$parent_status.' '.$column_layout.'">';
	}else if(($menu_type == "3")&&($column_layout == 'no-sub'))
	{
	$html .= '<ol class="'.$class.$parent_status.' no-sub-static-block">';
	}else
	{
	$html .= '<ol class="'.$class.$parent_status.'">';
	}
	
	$parent_status = '';
	foreach($allChild as $item)
    {
	if($item->getStatus()=="1")
	{
	$child_status = ' enabled';
	}else
	{
	$child_status = ' disabled';
	}
	
	$hasChild = $this->getChildMenuCollection($item->getMenuId());
	$url = Mage::helper("adminhtml")->getUrl("adminhtml/menucreator/edit/",array("id" => $item->getMenuId()));
	$add_sub_url = Mage::helper('adminhtml')->getUrl('adminhtml/menudata/addsubparent');
	$editformurl = Mage::helper("adminhtml")->getUrl("adminhtml/menucreator/editform/",array("id" => $item->getMenuId()));
	$add_sub = Mage::helper("adminhtml")->getUrl("adminhtml/menucreator/new/",array("group_id" => $item->getGroupId(),"parent_id" => $item->getMenuId()));
	$delete_url = Mage::helper("adminhtml")->getUrl("adminhtml/menucreator/deleteitems/",array("id" => $item->getMenuId()));
	$current_url = Mage::helper('core/url')->getCurrentUrl();
	
	 if(count($hasChild)>0) {
	$has_child_element = 'mjs-nestedSortable-branch mjs-nestedSortable-expanded ';
	}
	else
	{
	$has_child_element = 'mjs-nestedSortable-leaf ';
	}
	$sub_menu_type = trim($item->getType());
	$column_layout = trim($item->getSubcolumnlayout());
	if($item->getClassSubfix() != '')
	{
	$add_custom_class = $item->getClassSubfix();
	}else
	{
	$add_custom_class = '';
	}
	if(($column_layout == 'no-sub') && ($sub_menu_type == "3"))
	{
	$html .= '<li class="'.$has_child_element.$child_status.' '.$add_custom_class.' no-sub" id="menuItem_'.$item->getMenuId().'" store="'.$item->getStoreids().'"><div class="menuDiv">';
	}else
	{
	$html .= '<li class="'.$has_child_element.$child_status.' '.$add_custom_class.'" id="menuItem_'.$item->getMenuId().'" store="'.$item->getStoreids().'"><div class="menuDiv">';
	}
	 if(count($hasChild)>0) {
	 $html .= '<span class="disclose ui-icon ui-icon-minusthick" title="Click to show/hide children"><span></span></span>';
	 }
	 $html .= '<span class="itemTitle" data-id="'.$item->getMenuId().'">'.$item->getTitle().'</span><!--span class="edit-item"><a href='.$url.' title="'.$item->getTitle().'">Edit</a></span> | <span class="add-subitem"><a href='.$add_sub.' title="'.$item->getTitle().'">Add Sub</a></span-->
		 <button style="" onclick=editform("'.$editformurl.'"); class="scalable edit" type="button" title="Edit '.$item->getTitle().'"><span>Edit Menu</span></button>
		<button style="" onclick=addsub("'.$item->getGroupId().'","'.$item->getMenuId().'","'.$add_sub_url.'"); class="scalable add" type="button" title="Add in '.$item->getTitle().'"><span>Add Sub</span></button>
		<button style="" onclick=deleteitem("'.$delete_url.'","'.$current_url.'"); class="scalable delete" type="button" title="Delete '.$item->getTitle().'"><span></span></button>
	 </div>';
	$child_status = '';
	
	
	if(count($hasChild)>0)
	{
	$column_layout = trim($item->getSubcolumnlayout());
	$menu_type = trim($item->getType());
	$html .= $this->getTreeChild($item->getMenuId(),true,$column_layout,$menu_type);
	}
	
	 $html .= '</li>';
	}
	$html .= '</ol>';
	return $html;
}
	public function getMenuGroupdetails()
	{		$group_menu = array();
			$menugroup_grid = $this->getMenuGroup();
			
			foreach ($menugroup_grid as $group) {
				$group_details = Mage::getModel('navigationmenupro/menucreatorgroup')->load($group->getGroupId());
				$group_id = $group->getGroupId();
				$group_menu[$group_id] = $group_details->getTitle();
			}
			return $group_menu;
	}
	function getCategoriesforTree($parentId, $isChild){
    $allCats = Mage::getModel('catalog/category')->getCollection()
                ->addAttributeToSelect('*')
                ->addAttributeToFilter('parent_id',array('eq' => $parentId))
                ->addAttributeToSort('position', 'asc');
               
    $class = ($isChild) ? "sub-cat-list" : "cat-list";
    $html .= '<ul class="auto-sub '.$class.'">';
    foreach($allCats as $category)
    {
	if($category->getLevel() > 2)
	{	$lable = '';
		for($i=2;$i<=$category->getLevel();$i++)
		{
		$lable .= "\t".' -';
		}
	}
	
	?>
	
<?php 	
		
		$subcats = $category->getChildren();
		if($subcats != ''){
		$has_child_element = 'hassub';

		}
		 $html .= '<li class="'.$has_child_element.'"><a href=#><span>'.$lable.$category->getName().'</span></a>';
    	$lable = '';
		$has_child_element = '';
        if($subcats != ''){
            $html .= $this->getCategoriesforTree($category->getId(), true);
        }
		 $html .= '</li>';
    
    }
	 $html .= '</ul>';
	return $html;
    
}

public function getChildMenuItem($parentmenuid){
$chilMenu= Mage::getModel('navigationmenupro/menucreator')->getCollection()
				->addFieldToSelect('menu_id')
				->addFieldToFilter('parent_id',$parentmenuid);
				$childmenuitems = $chilMenu->getData();
				$this->child_menu_items[] = $parentmenuid;
				foreach($childmenuitems as $key => $value)
				{
				$this->child_menu_items[] = $value['menu_id'];
				$hasChild = $this->getChildMenuCollection($value['menu_id']);
				if(count($hasChild) > 0)
				{
				$this->child_menu_items[] = $this->getChildMenuItemTest($value['menu_id']);
				}
				}
				return $this->child_menu_items;
	

}
public function getChildMenuItemTest($parentmenuid){
$chilMenu= Mage::getModel('navigationmenupro/menucreator')->getCollection()
				->addFieldToSelect('menu_id')
				->addFieldToFilter('parent_id',$parentmenuid);
				
				$childmenuitems = $chilMenu->getData();
				foreach($childmenuitems as $key => $value)
				{
				$this->child_menu_items[] = $value['menu_id'];
				$hasChild = $this->getChildMenuCollection($value['menu_id']);
				if(count($hasChild) > 0)
				{
				$this->child_menu_items[] = $this->getChildMenuItemTest($value['menu_id']);
				}
				}
				return $this->child_menu_items;
	

}


}