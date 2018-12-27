<?php

namespace Chebotaryoff\CustomerStatus\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Customer\Setup\CustomerSetupFactory;

/**
 * @codeCoverageIgnore
 */
class InstallData implements InstallDataInterface
{
    /**
     * Customer setup factory
     *
     * @var CustomerSetupFactory
     */
    private $customerSetupFactory;

    /**
     * Init
     *
     * @param CustomerSetupFactory $customerSetupFactory
     */
    public function __construct(CustomerSetupFactory $customerSetupFactory)
    {
        $this->customerSetupFactory = $customerSetupFactory;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();

        /* @var \Magento\Catalog\Setup\CategorySetup $categorySetup */
        $customerSetup = $this->customerSetupFactory->create(['setup' => $setup]);
        $customerSetup->addAttribute(\Magento\Customer\Model\Customer::ENTITY, 'customer_status', [
            'type' => 'varchar',
            'label' => 'Customer Status',
            'input' => 'text',
            'required' => false,
            'sort_order' => 15,
            'validate_rules' => '{"max_text_length":255,"min_text_length":1}',
            'position' => 15,
            'user_defined' => true,
            'group' => 'General',
            'system' => false
        ]);

        $attributeId = $customerSetup->getAttributeId(\Magento\Customer\Model\Customer::ENTITY, 'customer_status');
        $data = [
            ['form_code' => 'adminhtml_customer', 'attribute_id' => $attributeId],
            ['form_code' => 'customer_account_edit', 'attribute_id' => $attributeId]
        ];
        $setup->getConnection()
            ->insertMultiple($setup->getTable('customer_form_attribute'), $data);

        $setup->endSetup();
    }
}
