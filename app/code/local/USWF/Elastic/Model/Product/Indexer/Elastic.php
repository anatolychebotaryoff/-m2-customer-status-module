<?php

class USWF_Elastic_Model_Product_Indexer_Elastic extends Mage_Index_Model_Indexer_Abstract {

    /**
     * Data key for matching result to be saved in
     */
    const EVENT_MATCH_RESULT_KEY = 'catalog_product_elastic_match_result';

    /**
     * Reindex elastic event type
     */
    const EVENT_TYPE_REINDEX_ELASTIC = 'catalog_reindex_elastic';

    /**
     * Matched Entities instruction array
     *
     * @var array
     */
    protected $_matchedEntities = array(
        Mage_Catalog_Model_Product::ENTITY => array(
            Mage_Index_Model_Event::TYPE_SAVE,
            Mage_Index_Model_Event::TYPE_DELETE,
            Mage_Index_Model_Event::TYPE_MASS_ACTION,
            self::EVENT_TYPE_REINDEX_ELASTIC,
        ),
        Mage_Core_Model_Config_Data::ENTITY => array(
            Mage_Index_Model_Event::TYPE_SAVE
        ),
        Mage_Catalog_Model_Convert_Adapter_Product::ENTITY => array(
            Mage_Index_Model_Event::TYPE_SAVE
        ),
        Mage_Customer_Model_Group::ENTITY => array(
            Mage_Index_Model_Event::TYPE_SAVE
        )
    );

    //TODO - invesitgate
    protected $_relatedConfigSettings = array(
        Mage_Catalog_Helper_Data::XML_PATH_PRICE_SCOPE,
        Mage_CatalogInventory_Model_Stock_Item::XML_PATH_MANAGE_STOCK
    );

    /**
     * Initialize resource model
     *
     */
    protected function _construct()
    {
        $this->_init('uswf_elastic/product_indexer_elastic');
    }

    protected function _getResource()
    {

        return Mage::getSingleton('uswf_elastic/resource_product_indexer_elastic');

    }

    /**
     * Retrieve Indexer name
     *
     * @return string
     */
    public function getName()
    {
        return Mage::helper('catalog')->__('Product Elastic Search Data');
    }

    /**
     * Retrieve Indexer description
     *
     * @return string
     */
    public function getDescription()
    {
        return Mage::helper('catalog')->__('Index product elastic data');
    }

    /**
     * Retrieve attribute list has an effect on product data
     *
     * @return array
     */
    protected function _getDependentAttributes()
    {
        return array(
            'price',
            'special_price',
            'special_from_date',
            'special_to_date',
            'tax_class_id',
            'status',
            'visibility',
            'sku',
            'name'
        );
    }

    /**
     * Check if event can be matched by process.
     * Re-written for checking configuration settings save (like  scope).
     *
     * @param Mage_Index_Model_Event $event
     * @return bool
     */
    public function matchEvent(Mage_Index_Model_Event $event)
    {
        $data = $event->getNewData();
        if (isset($data[self::EVENT_MATCH_RESULT_KEY])) {
            return $data[self::EVENT_MATCH_RESULT_KEY];
        }

        if ($event->getEntity() == Mage_Core_Model_Config_Data::ENTITY) {
            $data = $event->getDataObject();
            if ($data && in_array($data->getPath(), $this->_relatedConfigSettings)) {
                $result = $data->isValueChanged();
            } else {
                $result = false;
            }
        } elseif ($event->getEntity() == Mage_Customer_Model_Group::ENTITY) {
            $result = $event->getDataObject() && $event->getDataObject()->isObjectNew();
        } else {
            $result = parent::matchEvent($event);
        }

        $event->addNewData(self::EVENT_MATCH_RESULT_KEY, $result);

        return $result;
    }

    /**
     * Register data required by catalog product delete process
     *
     * @param Mage_Index_Model_Event $event
     */
    protected function _registerCatalogProductDeleteEvent(Mage_Index_Model_Event $event)
    {
        /* @var $product Mage_Catalog_Model_Product */
        $product = $event->getDataObject();

        $parentIds = $this->_getResource()->getProductParentsByChild($product->getId());
        if ($parentIds) {
            $event->addNewData('reindex_elastic_parent_ids', $parentIds);
        }
    }

    /**
     * Register data required by catalog product save process
     *
     * @param Mage_Index_Model_Event $event
     */
    protected function _registerCatalogProductSaveEvent(Mage_Index_Model_Event $event)
    {
        /* @var $product Mage_Catalog_Model_Product */
        $product      = $event->getDataObject();
        $attributes   = $this->_getDependentAttributes();
        $reindexElastic = $product->getIsRelationsChanged() || $product->getIsCustomOptionChanged()
            || $product->dataHasChangedFor('tier_price_changed')
            || $product->getIsChangedWebsites()
            || $product->getForceReindexRequired();

        foreach ($attributes as $attributeCode) {
            $reindexElastic = $reindexElastic || $product->dataHasChangedFor($attributeCode);
        }

        if ($reindexElastic) {
            $event->addNewData('product_type_id', $product->getTypeId());
            $event->addNewData('reindex_elastic', 1);
        }
    }

    protected function _registerCatalogProductMassActionEvent(Mage_Index_Model_Event $event)
    {
        /* @var $actionObject Varien_Object */
        $actionObject = $event->getDataObject();
        $attributes   = $this->_getDependentAttributes();
        $reindexElastic = false;

        // check if attributes changed
        $attrData = $actionObject->getAttributesData();
        if (is_array($attrData)) {
            foreach ($attributes as $attributeCode) {
                if (array_key_exists($attributeCode, $attrData)) {
                    $reindexElastic = true;
                    break;
                }
            }
        }

        // check changed websites
        if ($actionObject->getWebsiteIds()) {
            $reindexElastic = true;
        }

        // register affected products
        if ($reindexElastic) {
            $event->addNewData('reindex_elastic_product_ids', $actionObject->getProductIds());
        }
    }

    /**
     * Register data required by process in event object
     *
     * @param Mage_Index_Model_Event $event
     */
    protected function _registerEvent(Mage_Index_Model_Event $event)
    {
        $event->addNewData(self::EVENT_MATCH_RESULT_KEY, true);
        $entity = $event->getEntity();

        if ($entity == Mage_Core_Model_Config_Data::ENTITY || $entity == Mage_Customer_Model_Group::ENTITY) {
            $process = $event->getProcess();
            $process->changeStatus(Mage_Index_Model_Process::STATUS_REQUIRE_REINDEX);
        } else if ($entity == Mage_Catalog_Model_Convert_Adapter_Product::ENTITY) {
            $event->addNewData('catalog_product_elastic_reindex_all', true);
        } else if ($entity == Mage_Catalog_Model_Product::ENTITY) {
            switch ($event->getType()) {
                case Mage_Index_Model_Event::TYPE_DELETE:
                    $this->_registerCatalogProductDeleteEvent($event);
                    break;

                case Mage_Index_Model_Event::TYPE_SAVE:
                    $this->_registerCatalogProductSaveEvent($event);
                    break;

                case Mage_Index_Model_Event::TYPE_MASS_ACTION:
                    $this->_registerCatalogProductMassActionEvent($event);
                    break;
                case self::EVENT_TYPE_REINDEX_ELASTIC:
                    $event->addNewData('id', $event->getDataObject()->getId());
                    break;
            }

            // call product type indexers registerEvent
            $indexers = $this->_getResource()->getTypeIndexers();
            foreach ($indexers as $indexer) {
                $indexer->registerEvent($event);
            }
        }
    }

    /**
     * Process event
     *
     * @param Mage_Index_Model_Event $event
     */
    protected function _processEvent(Mage_Index_Model_Event $event)
    {
        Mage::log("process called");
        $data = $event->getNewData();
        if ($event->getType() == self::EVENT_TYPE_REINDEX_ELASTIC) {
            $this->_getResource()->reindexProductIds($data['id']);
            return;
        }
        if (!empty($data['catalog_product_elastic_reindex_all'])) {
            $this->reindexAll();
        }
        if (empty($data['catalog_product_elastic_skip_call_event_handler'])) {
            $this->callEventHandler($event);
        }
    }

}