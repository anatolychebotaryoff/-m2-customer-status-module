<?php
    
    $installer = $this;
    
    if(!$installer->tableExists('hardness/table_zipcodes')) {
        $installer->startSetup();
        
        $table = $installer->getConnection()
            ->newTable($this->getTable('hardness/table_zipcodes'))
            ->addColumn('hardness_id', Varien_Db_Ddl_Table::TYPE_INTEGER, null, array(
                'identity' 	=> true,	// is autoincrement
                'unsigned' 	=> true,
                'nullable' 	=> false,	// is null
                'primary' 	=> true,	// is PRIMARY_KEY
            ))
            ->addColumn('zip_code', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable'	=> false,
            ))
            ->addColumn('hardness_range', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' 	=> false,
            ))
            ->addColumn('primary_city', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' 	=> false,
            ))
            ->addColumn('secondary_cities', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' 	=> true,
            ))
            ->addColumn('state', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' 	=> false,
            ))
            ->addColumn('county', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' 	=> false,
            ))
            ->addColumn('country', Varien_Db_Ddl_Table::TYPE_VARCHAR, null, array(
                'nullable' 	=> false,
            ));
        
        $installer->getConnection()->createTable($table);
        
        $installer->endSetup();
    }