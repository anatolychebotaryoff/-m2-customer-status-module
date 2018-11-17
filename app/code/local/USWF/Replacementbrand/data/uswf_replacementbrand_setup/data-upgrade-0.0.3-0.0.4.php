<?php

$installer = $this;
$installer->startSetup();

$nodeModel = Mage::getModel('enterprise_cms/hierarchy_node');
$rbWebsite = Mage::getModel('core/website')->load('rb');
$nodeModel->setScope(Enterprise_Cms_Model_Hierarchy_Node::NODE_SCOPE_WEBSITE);
$nodeModel->setScopeId($rbWebsite->getId());
$nodeModel->deleteByScope(Enterprise_Cms_Model_Hierarchy_Node::NODE_SCOPE_WEBSITE, $rbWebsite->getId());
$nodeModel->collectTree(array(), array());

$installer->endSetup();