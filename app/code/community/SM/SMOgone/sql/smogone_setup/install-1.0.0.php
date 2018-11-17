<?php
 
 $installer = $this;
 
 $installer->startSetup();
 
 $installer->run("
 
 DELETE FROM {$this->getTable('sales_order_status')} WHERE status LIKE '%ogone%' ;
 
 ");
 
 $installer->endSetup();
