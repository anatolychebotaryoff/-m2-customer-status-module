<?php
/**
 * Banners.php
 *
 * @category    USWF
 * @package     USWF_Smartfit
 * @copyright
 * @author
 */
class USWF_Smartfit_Block_Megamenu_Navigation extends Cmsmart_Megamenu_Block_Navigation
{
    public function getLevle($id){
        $megamenu = Mage::helper('megamenu')->Megamenu($id);
        if(isset($megamenu[0]['level_column_count']) && $megamenu[0]['level_column_count'] != 0){
            return $megamenu[0]['level_column_count'];
        } else {
            $level = 1;
            return $level;
        }
    }

    public function backgroundcolor($megamenu){
        if(isset($megamenu[0]['background-color']) && $megamenu[0]['background-color']) {
            return $megamenu[0]['background-color'];
        } else {
            return ;
        }
    }

    public function fontcolor($megamenu){
        if(isset($megamenu[0]['font-color']) && $megamenu[0]['font-color']) {
            return $megamenu[0]['font-color'];
        } else {
            return ;
        }
    }

    public function getLabel($megamenu){
        if(isset($megamenu[0]['active_label']) && $megamenu[0]['active_label'] == 1){
            return '<span  class="cat-label pin-bottom">'.$megamenu[0]['label'].'</span>';
        } else {
            return ;
        }
    }

    protected function _renderCategoryMenuItemHtml($category, $level = 0, $isLast = false, $isFirst = false,
                                                   $isOutermost = false, $outermostItemClass = '', $childrenWrapClass = '', $noEventAttributes = false)
    {


        $showthumbnail = Mage::helper('megamenu')->getShowthumbnail($category->getId());

        $width = Mage::getStoreConfig('megamenu/mainmenu/width_thumbnail_category');
        $height= Mage::getStoreConfig('megamenu/mainmenu/height_thumbnail_category');
        if (!$category->getIsActive()) {
            return '';
        }
        $html = array();
        if (Mage::helper('catalog/category_flat')->isEnabled()) {
            $children = (array)$category->getChildrenNodes();
            $childrenCount = count($children);
        } else {
            $children = $category->getChildren();
            $childrenCount = $children->count();
        }
        $hasChildren = ($children && $childrenCount);
        $activeChildren = array();

        foreach ($children as $child) {
            if ($child->getIsActive()) {
                $activeChildren[] = $child;
            }

        }

        $activeChildrenCount = count($activeChildren);
        $hasActiveChildren = ($activeChildrenCount > 0);
        $classes = array();
        $classes[] = 'level' . $level;
        $classes[] = 'nav-' . $this->_getItemPosition($level);
        if ($this->isCategoryActive($category)) {
            $classes[] = 'active';
        }
        $linkClass = '';
        if ($isOutermost && $outermostItemClass) {
            $classes[] = $outermostItemClass;
            $linkClass = ' class="'.$outermostItemClass.'"';
        }
        if ($isFirst) {
            $classes[] = 'first';
        }
        if ($isLast) {
            $classes[] = 'last';
        }
        if ($hasActiveChildren) {
            $classes[] = 'parent';
        }
        if ($this->_isAccordion == FALSE && $level == 1) {
            $classes[] = 'item';
        }
        $column = $this->getLevle($category->getId()) ;


        $attributes = array();
        if (count($classes) > 0) {
            $attributes['class'] = implode(' ', $classes);
        }
        if ($hasActiveChildren && !$noEventAttributes) {
            $attributes['onmouseover'] = 'toggleMenu(this,0)';
            $attributes['onmouseout'] = 'toggleMenu(this,0)';
        }
        if($showthumbnail != 1){
            $nothumbnail = ' no-level-thumbnail ';
        } else {
            $nothumbnail = ' level-thumbnail';
        }
        $htmlLi = '<li ';



        foreach ($attributes as $attrName => $attrValue) {
            $htmlLi .= ' ' . $attrName .  '="' . str_replace('"', '\"', $attrValue) . ' ' . $nothumbnail . '"';
        }

        if($level == 1) {
            $idc =  $category->parent_id;
            $widthp = $this->widthp($idc);
            $htmlLi .= 'style="width:'.$widthp.'%;">';


        } else {
            $htmlLi .= '>';
        }
        $html[] = $htmlLi;
        $id = $category->getId();
        $megamenu = Mage::helper('megamenu')->Megamenu($id);
        $cat=Mage::getModel('catalog/category')->load($category->getId());
        $model=$cat->getDisplay_mode();
        $imgaes =  Mage::getModel('catalog/category')->load($category->getId())->getThumbnail();
        if($level == 1){
            $html[] = '<a style="background-color:'. $this->backgroundcolor($megamenu).' border-bottom: 2px solid '.$this->fontcolor($megamenu).'" class="catagory-level1" href="'.$this->getCategoryUrl($category).'"'.$linkClass.'>';
        } else {
            $html[] = '<a  style="background-color:'. $this->backgroundcolor($megamenu).'" href="'.$this->getCategoryUrl($category).'"' .$linkClass.'>';
        }
        if($showthumbnail == 1){
            if ($imgaes) {
                $html[] = '<img src="' . Mage::getBaseUrl('media').'catalog/category/' . $imgaes .'" width="'.$width.'" height="'.$height.'" style="float: left;z-index: 1" />' ;
            }else {
                $html[] = '<div class="thumbnail"></div>';
            }
        } else {
            $html[] = '<div class="thumbnail"></div>';
        }


        if(
            ($childrenCount && $megamenu[0]['category_children']==0) || 
            (isset($megamenu[0]['active_product']) && $megamenu[0]['active_product'] == 1) || 
            (isset($megamenu[0]['active_static_block']) && $megamenu[0]['active_static_block']==1)
        ){
            $html[] = '<span style="color:'.$this->fontcolor($megamenu).';">' . $this->escapeHtml($category->getName()).$this->getLabel($megamenu).'</span><span class="spanchildren"></span>';
        } else{
            $html[] = '<span style="color:'.$this->fontcolor($megamenu).';  ">' . $this->escapeHtml($category->getName()).$this->getLabel($megamenu).'</span>';
        }
        $html[] = '</a>';
        if($level == 1) {  $html[] =''; }
        if($level == 3) {  $html[] =''; }
        // render children
        $htmlChildren = '';
        $j = 0;
        foreach ($activeChildren as $child) {
            $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                $child,
                ($level + 1),
                ($j == $activeChildrenCount - 1),
                ($j == 0),
                false,
                $outermostItemClass,
                $childrenWrapClass,
                $noEventAttributes
            );

            $j++;
        }

        $standard_menu = Mage::getStoreConfig('megamenu/mainmenu/standard_menu');
        if($standard_menu == 1) {
            $addclass = 'standard_menu';
        } else {
            $addclass = '';
        }
        if ($this->_isAccordion == TRUE)
            $html[] = '<span class="opener">&nbsp;</span>';

        if ($childrenWrapClass) {
            if(!$level){
                $html[] = '<div class="' . $childrenWrapClass  . '">';
            } else {
                $html[] = '<div class="' . $childrenWrapClass  .'">';
            }
        }
        if($level == 0) {
            $width_menu = Mage::getStoreConfig('megamenu/mainmenu/width_menu') - 20;
            $html[] = '<ul class="level' . $level .' '. $addclass .' column'.$this->getLevle($id).'" style="width:'.$width_menu. 'px;">';
        } else {
            $html[] = '<ul class="level' . $level .' '. $addclass .' column'.$this->getLevle($id).'">';
        }
        $html[] = $this->getBlockTop($megamenu);

        $classblock = '';
        
        if($level == 0) {
            if(isset($megamenu[0]['active_product']) && $megamenu[0]['active_product']==1){
                $numbers = $megamenu[0]['numbers_product'];
                $showproduct = $this->htmlshownumberproduct($category,$id,$numbers,$level);
                $html[] = $showproduct;
            }
            if($this->getBlockLeft($megamenu)) {
                $classblock =' menu-content';
            }
            $html[] = '<ul class=" level' . $level . $classblock.'">'.$this->getBlockLeft($megamenu);
            $html[] = $this->getBlockRight($megamenu);

            if(isset($megamenu[0]['category_children']) && $megamenu[0]['category_children']==0)   {
                if($htmlChildren) {
                    if($level == 0){
                        $widthchildren =  $this->width($id);
                        $html[] = '<div class="catagory_children" style="width:'.$widthchildren.'px;">'.$htmlChildren.'</div>';

                    } else {
                        $html[] = '<div class="catagory_children column'.$this->getLevle($id).'">'.$htmlChildren.'</div>';
                    }
                }
            }
        }  else{
            if($this->getBlockLeft($megamenu)) {
                $classblock =' menu-content';
            }
            $html[] = '<ul class=" level' . $level . $classblock.'">'.$this->getBlockLeft($megamenu);
            if(isset($megamenu[0]['category_children']) && $megamenu[0]['category_children']==0)   {
                if($htmlChildren) {
                    $idc =  $category->parent_id;
                    $widthchildren = $this->width($idc);

                    $widthc =  Mage::helper('megamenu')->Megamenu($id);
                    $left = (($widthc[0]['width_block_left'] + 10)/$widthchildren)*100;
                    $w = floor($widthp - $left);
                    $widthchildrenc = ($w * $widthchildren)/100;

                    if(($widthc[0]['active_static_block'] == 1 ) && ($widthc[0]['active_static_block_left'] == 1 ) && ($widthc[0]['active_static_block_right'] == 1 )) {
                        $classchildren = 'leftrightchildren';
                        $html[] = '<div class="catagory_children '. $classchildren  .' column'.$this->getLevle($id).'" style="width:'.$widthchildrenc.'px">'.$htmlChildren.'</div>';
                    } else if(($widthc[0]['active_static_block'] == 1 ) && ($widthc[0]['active_static_block_left'] == 1 ) && ($widthc[0]['active_static_block_right'] == 0 )){
                        $classchildren = 'leftchildren';
                        $html[] = '<div class="catagory_children '. $classchildren  .' column'.$this->getLevle($id).'" style="width:'.$widthchildrenc.'px">'.$htmlChildren.'</div>';
                    } else if(($widthc[0]['active_static_block'] == 1 ) && ($widthc[0]['active_static_block_left'] == 0 ) && ($widthc[0]['active_static_block_right'] == 1 )){
                        $classchildren = 'rightchildren';
                        $html[] = '<div class="catagory_children '. $classchildren  .' column'.$this->getLevle($id).'" style="width:'.$widthchildrenc.'px">'.$htmlChildren.'</div>';
                    } else{
                        $classchildren = '';
                        $html[] = '<div class="catagory_children '. $classchildren  .' column'.$this->getLevle($id).'">'.$htmlChildren.'</div>';
                    }

                }
            }
            $html[] = $this->getBlockRight($megamenu);
            if(isset($megamenu[0]['active_product']) && $megamenu[0]['active_product']==1){
                $numbers = $megamenu[0]['numbers_product'];
                $showproduct = $this->htmlshownumberproduct($category,$id,$numbers,$level);
                $html[] = $showproduct;
            }
        }
        $html[] = '</ul>'.$this->getBlockBottom($megamenu);

        $html[] = '</ul>';
        if ($childrenWrapClass) {
            $html[] = '</div>';
        }
        $html[] = '</li>';
        $html = implode("\n", $html);
        return $html;
    }

    public function getBlockTop($block){
        if (!isset($block[0])) {
            return '';
        } else {
            return parent::getBlockTop($block);
        }
    }

    public function getBlockLeft($block){
        if (!isset($block[0])) {
            return '';
        } else {
            return parent::getBlockLeft($block);
        }
    }

    public function getBlockRight($block){
        if (!isset($block[0])) {
            return '';
        } else {
            return parent::getBlockRight($block);
        }
    }

    public function getBlockBottom($block){
        if (!isset($block[0])) {
            return '';
        } else {
            return parent::getBlockBottom($block);
        }
    }

    public function width($id){
        $width =  Mage::helper('megamenu')->Megamenu($id);
        $width_menu = Mage::getStoreConfig('megamenu/mainmenu/width_menu');
        if(($width[0]['active_static_block'] == 1 )&& ($width[0]['active_static_block_left'] == 1 ) && ($width[0]['active_static_block_right'] == 1 )) {
            $widthchildren = $width_menu -  $width[0]['width_block_left'] -  $width[0]['width_block_right']-40;
        } else {
            if(($width[0]['active_static_block'] == 1 )&& ($width[0]['active_static_block_left'] == 1 ) && ($width[0]['active_static_block_right'] == 0 )) {
                $widthchildren = $width_menu -  $width[0]['width_block_left']-30;
            } else {
                if(($width[0]['active_static_block'] == 1 ) && ($width[0]['active_static_block_left'] == 0 ) && ($width[0]['active_static_block_right'] == 1 )) {
                    $widthchildren = $width_menu -  $width[0]['width_block_right'] - 30;
                } else{
                    $widthchildren = $width_menu;
                }
            }
        }
        return $widthchildren;
    }
}