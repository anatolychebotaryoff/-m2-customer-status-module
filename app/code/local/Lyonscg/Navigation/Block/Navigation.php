<?php

class Lyonscg_Navigation_Block_Navigation extends Mage_Catalog_Block_Navigation
{
    /**
     * Render category to html
     *
     * @param Mage_Catalog_Model_Category $category
     * @param int Nesting level number
     * @param boolean Whether ot not this item is last, affects list item class
     * @param boolean Whether ot not this item is first, affects list item class
     * @param boolean Whether ot not this item is outermost, affects list item class
     * @param string Extra class of outermost list items
     * @param string If specified wraps children list in div with this class
     * @param boolean Whether ot not to add on* attributes to list item
     * @return string
     */
    protected function _renderCategoryMenuItemHtml($category, $level = 0, $isLast = false, $isFirst = false, $isOutermost = false, $outermostItemClass = '', $childrenWrapClass = '', $noEventAttributes = false)
    {
        $categoryResource = Mage::getResourceModel("catalog/category");
        $storeId = Mage::app()->getStore()->getId();

        $html = array();
        if ($level < 3) {
            if (!$category->getIsActive()) {
                return '';
            }

            // get all children
            if (Mage::helper('catalog/category_flat')->isEnabled()) {
                $children = (array) $category->getChildrenNodes();
                $childrenCount = count($children);
            } else {
                $children = $category->getChildren();
                $childrenCount = $children->count();
            }
            $hasChildren = ($children && $childrenCount);

            // select active children

            if ($level == 0) {
                asort($children, SORT_ASC);
            }
            $activeChildren = array();
            foreach ($children as $child) {
                if ($child->getIsActive()) {
                    // make sure categories have position loaded
                    $position = $categoryResource->getAttributeRawValue($child->getId(), 'position', $storeId);
                    $child->setPosition($position);
                    $activeChildren[] = $child;
                }
            }

            if (count($activeChildren)) {
                // sort menu children by position
                usort($activeChildren, function($cat1, $cat2) {
                    $p1 = $cat1->getPosition();
                    $p2 = $cat2->getPosition();
                    if ($p1 == $p2)
                    {
                        return 0;
                    }
                    return ($p1 < $p2) ? -1 : 1;
                });
            }

            $activeChildrenCount = count($activeChildren);
            $hasActiveChildren = ($activeChildrenCount > 0);

            // prepare list item html classes
            $classes = array();
            $classes[] = 'level' . $level;
            $classes[] = 'nav-' . $this->_getItemPosition($level);
            if ($this->isCategoryActive($category)) {
                $classes[] = 'active';
            }
            $linkClass = '';
            if ($isOutermost && $outermostItemClass) {
                $classes[] = $outermostItemClass;
                $linkClass = ' class="' . $outermostItemClass . '"';
            }
            if ($isFirst) {
                $classes[] = 'first';
            }
            if ($isLast) {
                $classes[] = 'last';
            }
            if ($hasActiveChildren && $level < 2) {
                $classes[] = 'parent';
            }

            // prepare list item attributes
            $attributes = array();
            if (count($classes) > 0) {
                $attributes['class'] = implode(' ', $classes);
            }
            if ($hasActiveChildren && !$noEventAttributes) {
                $attributes['onmouseover'] = 'toggleMenu(this,1)';
                $attributes['onmouseout'] = 'toggleMenu(this,0)';
            }

            // assemble list item with attributes
            $htmlLi = '<li';
            foreach ($attributes as $attrName => $attrValue) {
                $htmlLi .= ' ' . $attrName . '="' . str_replace('"', '\"', $attrValue) . '"';
            }
            $htmlLi .= '>';
            $html[] = $htmlLi;

            $html[] = '<a href="' . $this->getCategoryUrl($category) . '"' . $linkClass . '>';


            $shortname = $categoryResource->getAttributeRawValue($category->getId(), 'short_name', $storeId);
            if ($shortname) {
                $html[] = '<span>' . $this->escapeHtml($shortname) . '</span>';
            } else {
                $html[] = '<span>' . $this->escapeHtml($category->getName()) . '</span>';
            }
            $html[] = '</a>';

            // render children
            $htmlChildrens1 = '';
            $htmlChildrens2 = '';
            $htmlChildrens3 = '';
            $htmlChildrens4 = '';
            $htmlChildren = '';
            $j = 0;
            $i = 1;

            foreach ($activeChildren as $child) {
                if ($level == 0) {
                    $htmlChildren = $this->_renderCategoryMenuItemHtml(
                        $child, ($level + 1), ($j == $activeChildrenCount - 1), ($j == 0), false, $outermostItemClass, $childrenWrapClass, $noEventAttributes
                    );
                    if ($i % 4 == 1) {
                        $htmlChildrens1 .= $htmlChildren;
                    } elseif ($i % 4 == 2) {
                        $htmlChildrens2 .= $htmlChildren;
                    } elseif ($i % 4 == 3) {
                        $htmlChildrens3 .= $htmlChildren;
                    } elseif ($i % 4 == 0) {
                        $htmlChildrens4 .= $htmlChildren;
                    }
                    $i++;
                    $j++;
                } else {
                    $htmlChildren .= $this->_renderCategoryMenuItemHtml(
                        $child, ($level + 1), ($j == $activeChildrenCount - 1), ($j == 0), false, $outermostItemClass, $childrenWrapClass, $noEventAttributes
                    );
                    $j++;
                }
            }

            if (!empty($htmlChildren)) {
                if ($childrenWrapClass) {
                    $html[] = '<div class="' . $childrenWrapClass . '">';
                }
                if ($level == 0) {
                    $html[] = '<div class="wrap"><ul class="level' . $level . '">';
                    $staticImage = $this->getLayout()->createBlock('cms/block')->setBlockId('top_menu_' . $category->getId())->toHtml();
                    ;
                    if ($staticImage) {
                        $html[] = '<li class="top-menu-image">' . $staticImage . '</li>';
                    }

                    $html[] = '<li class="column first"><ul>' . $htmlChildrens1 . '</ul></li>'
                        . '<li class="column"><ul>' . $htmlChildrens2 . '</ul></li>'
                        . '<li class="column"><ul>' . $htmlChildrens3 . '</ul></li>'
                        . '<li class="column"><ul>' . $htmlChildrens4 . '</ul></li>';
                } else {
                    $html[] = '<ul class="level' . $level . '">';
                    $html[] = $htmlChildren;
                }
                $html[] = '</ul>';
                if ($level == 0) {
                    if ($shortname) {
                        $html[] = '<div class="see-all"><a href="' . $category->getUrl() . '">See All ' . $shortname . ' ></a></div></div>';
                    } else {
                        $html[] = '<div class="see-all"><a href="' . $category->getUrl() . '">See All ' . $category->getName() . ' ></a></div></div>';
                    }
                }
                if ($childrenWrapClass) {
                    $html[] = '</div>';
                }
            }

            $html[] = '</li>';
            $html = implode("\n", $html);
        }
        return is_array($html) ? implode("\n", $html) : $html;
    }
}