<?php

$installer = $this;
$installer->startSetup();

/**
 * Drop AdvancedReviews tables ===COMMENTED BEFORE APPROVAL===
 */
/**
if ($installer->getConnection()->isTableExists($this->getTable('advancedreviews/helpfulness'))) {
    $installer->getConnection()->dropForeignKey($this->getTable('advancedreviews/helpfulness'), 'FK_reviews_helpfulness');
    $installer->getConnection()->dropTable($this->getTable('advancedreviews/helpfulness'));
}
if ($installer->getConnection()->isTableExists($this->getTable('advancedreviews/abuse'))) {
    $installer->getConnection()->dropForeignKey($this->getTable('advancedreviews/abuse'), 'FK_reviews_abuse');
    $installer->getConnection()->dropForeignKey($this->getTable('advancedreviews/abuse'), 'FK_reviews_abuse_store');
    $installer->getConnection()->dropTable($this->getTable('advancedreviews/abuse'));
}
if ($installer->getConnection()->isTableExists($this->getTable('advancedreviews/proscons_vote'))) {
    $installer->getConnection()->dropForeignKey($this->getTable('advancedreviews/proscons_vote'), 'FK_reviews_pc_votes');
    $installer->getConnection()->dropForeignKey($this->getTable('advancedreviews/proscons_vote'), 'FK_proscons_votes');
    $installer->getConnection()->dropTable($this->getTable('advancedreviews/proscons_vote'));
}
if ($installer->getConnection()->isTableExists($this->getTable('advancedreviews/abuse'))) {
    $installer->getConnection()->dropForeignKey($this->getTable('advancedreviews/abuse'), 'FK_proscons_pc');
    $installer->getConnection()->dropForeignKey($this->getTable('advancedreviews/abuse'), 'FK_proscons_pc_store');
    $installer->getConnection()->dropTable($this->getTable('advancedreviews/abuse'));
}
if ($installer->getConnection()->isTableExists($this->getTable('advancedreviews/recommend'))) {
    $installer->getConnection()->dropForeignKey($this->getTable('advancedreviews/recommend'), 'FK_reviews_recommend');
    $installer->getConnection()->dropTable($this->getTable('advancedreviews/recommend'));
}
if ($installer->getConnection()->isTableExists($this->getTable('advancedreviews/proscons'))) {
    $installer->getConnection()->dropTable($this->getTable('advancedreviews/proscons'));
}
if ($installer->getConnection()->isTableExists($this->getTable('advancedreviews/proscons_store'))) {
    $installer->getConnection()->dropTable($this->getTable('advancedreviews/proscons_store'));
}
 */

$installer->endSetup();
