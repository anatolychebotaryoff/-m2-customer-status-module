<?php

/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @copyright  Copyright (c) 2013 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * SEO Suite extension
 *
 * @category   MageWorx
 * @package    MageWorx_SeoSuite
 * @author     MageWorx Dev Team
 */
class MageWorx_Seosuite_Block_Adminhtml_Template_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('templateGrid');
        $this->setUseAjax(true);
        $this->setDefaultSort('entity_id');
        $this->setSaveParametersInSession(true);
    }

    public function getStoreId()
    {
        $store = $this->getRequest()->getParam('store');
        if (!$store) {
            $store = 0;
        }
        return $store;
    }

    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        $this->unsetChild('reset_filter_button');
        $this->unsetChild('search_button');
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('seosuite/template_collection');
        $collection->addDate($this->getStoreId());
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $this->addColumn('template_id',
                array(
            'header'   => Mage::helper('customer')->__('ID'),
            'index'    => 'template_id',
            'type'     => 'number',
            'filter'   => false,
            'sortable' => false,
        ));

        $this->addColumn('template_name',
                array(
            'header'   => Mage::helper('customer')->__('Template name'),
            'index'    => 'template_name',
            'filter'   => false,
            'sortable' => false,
        ));

        $this->addColumn('last_update',
                array(
            'header'   => Mage::helper('customer')->__('Last modified'),
            'index'    => 'last_update',
            'type'     => 'date',
            'align'    => 'center',
            'default'  => '---',
            'renderer' => 'seosuite/adminhtml_template_grid_date',
            'filter'   => false,
            'sortable' => false,
        ));

        $this->addColumn('action_apply',
                array(
            'header'    => Mage::helper('customer')->__('Apply Template'),
            'type'      => 'action',
            'getter'    => 'getId',
            'width'     => '50px',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('customer')->__('Apply'),
                    'onclick' => "if(confirm('This action cannot be canceled. Are you sure you want to continue?')) { return true; } else { return false; }",
                    'url'     => array('base'   => '*/*/apply',
                    'params'  => array('store' => $this->getStoreId())),
                    'field'   => 'template_id'
                ),
            ),
            'filter'    => false,
            'sortable'  => false,
            'is_system' => true,
        ));
        $this->addColumn('action_edit',
                array(
            'header'    => Mage::helper('customer')->__('Edit Template'),
            'type'      => 'action',
            'getter'    => 'getId',
            'actions'   => array(
                array(
                    'caption' => Mage::helper('customer')->__('Edit'),
                    'url'     => array('base'   => '*/*/edit',
                    'params'  => array('store' => $this->getStoreId())),
                    'field'   => 'template_id',
                )
            ),
            'width'     => '50px',
            'filter'    => false,
            'sortable'  => false,
            'is_system' => true,
        ));
        if (!Mage::app()->getRequest()->getParam('store', 0)) {
            $this->addColumn('status',
                    array(
                'header'   => Mage::helper('customer')->__('Enable/Disable Template'),
                'index'    => 'status',
                'type'     => 'text',
                'align'    => 'center',
                'renderer' => 'seosuite/adminhtml_template_grid_status',
                'filter'   => false,
                'sortable' => false,
            ));
        }
        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit',
                        array('template_id' => $row->getId(), 'store' => Mage::app()->getRequest()->getParam('store', 0)));
    }

    public function _toHtml()
    {
        $html = parent::_toHtml();
        $html .= "<script type='text/javascript'>
                    $$('.pager').each(function(el){
                        el.innerHTML = '';
                    });

                    $$('.action-select').each(function(el) {
                        el.observe('change',function(elem) {
                            var val = $(elem.id+' option:selected').text();
                            alert(val);

                        });
                    });
                </script>";
        return $html;
    }

}
