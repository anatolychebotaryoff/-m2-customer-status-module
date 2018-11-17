<?php
/**
 * Current class have methods to work with products collections and their attributes
 *
 * @category    Lyonscg
 * @package     Lyonscg_FilterFinder
 * @copyright   Copyright (c) 2012 Lyons Consulting Group (www.lyonscg.com)
 * @author      Shcherba Yuriy (yscherba@lyonscg.com)
 * @author      Ashutosh Potdar (apotdar@lyonscg.com)
 */

/**
 * Filter Finder Block
 *
 * @category    Lyonscg
 * @package     Lyonscg_FilterFinder
 * @copyright   Copyright (c) 2012 Lyons Consulting Group (www.lyonscg.com)
 * @author      Shcherba Yuriy (yscherba@lyonscg.com)
 * @author      Ashutosh Potdar (apotdar@lyonscg.com)
 */
class Lyonscg_FilterFinder_Block_Filterfinder extends Mage_Core_Block_Template
{

    /**
     * Hardcoded array of 4 attributes codes used in filter finder
     *
     * @var array
     */
    public $steps = array(
        'filter_finder_brand' => NULL,
        'filter_finder_style' => NULL,
        'filter_finder_location' => NULL,
        'filter_finder_removal' => NULL
    );

    /**
     * Shows current FilterFinder current step
     *
     * @var integer
     */
    public $currentStep = 0;

    /**
     * Current category is always Fridge Filter Finder
     *
     * @var mixed
     */
    public $currentCategory = NULL;

    /**
     * The nextStep variable contains attribute code of next step
     *
     * @var string
     */
    public $nextStep = NULL;

    /**
     * The allSteps variable contains array with urls, attributes options ids and labels for each step
     *
     * @var mixed
     */
    public $allSteps = NULL;

    /**
     * Variable for checking if the frontend is secure
     *
     * @var boolean
     */
    private $_secureFrontend = null;

    /**
     * Class Constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->initSteps();
    }

    /**
     * Function initializes class variables
     *
     * @return void
     */
    public function initSteps()
    {
        foreach ($this->steps as $key => $parameter) {
            $this->steps[$key] = $this->getRequest()->getParam($key, NULL);
        }
        $this->getCurrentStep();
        $this->setCurrentCategory();
        $this->allSteps = $this->prepareAllStepsData();
    }

    /**
     * Function sets different category as current in dependency of store
     *
     * @return void
     */
    public function setCurrentCategory()
    {
        $storeCode = Mage::app()->getStore()->getCode();
        switch ($storeCode) {
            case 'ff_en':
                $_catName = 'Fridge Filter Finder';
                break;
            case 'dfs_en':
                $_catName = 'Discount Filter Finder';
                break;
        }
        $this->currentCategory = Mage::getModel('catalog/category')->loadByAttribute('name', $_catName);
    }

    /**
     * Function returns attribute option id if one has it or null if not
     *
     * @param string $key
     * @param string $value
     * @return null
     */
    public function getAttributeOptionId($key, $value)
    {
        $productModel = Mage::getModel('catalog/product');
        $attr = $productModel->getResource()->getAttribute($key);
        if ($attr->usesSource()) {
            return $attr->getSource()->getOptionId($value);
        }
        return NULL;
    }

    /**
     * Function returns product collection with offset $currentPage
     *
     * @param int $currentPage
     * @return mixed
     */
    public function prepareProductCollection($currentPage = 1)
    {
        $steps = $this->steps;

        // Get the Current Store ID
        $storeId = Mage::app()->getStore()->getId();
        // Create Model to extract attributes and products.
        $ffModel = Mage::getModel('lyonscg_filterfinder/filterfinder')
                ->getCollection();
        // Select only the product_entity_id field.
        $ffModel->addFieldToSelect('product_entity_id');
        // Set Distinct to true
        $ffModel->getSelect()->distinct(true);
        // Filter by correct store id.
        $ffModel->addFieldToFilter('website_id', $storeId);

        // Add the items from the selection of attributes.
        foreach ($steps as $key => $value) {
            if (is_null($value) || $value == '') {
                break;
            }
            $attributeId = $this->getAttributeOptionId($key, $value);
            // filter out based on the value selected.
            $ffModel->addFieldToFilter($key, array('eq' => $attributeId));
        }

        // Create a product collection.
        $collection = Mage::getModel('catalog/product')->getCollection();
        // Select everything
        $collection->addAttributeToSelect('*');
        // Filter by Correct Store ID.
        $collection->setStoreId($storeId);
        // Add "as low as string" to the product.
        $collection->addMinimalPrice();

        $productIds = array();
        // Loop through the $ffModel to get all the product ids.
        foreach ($ffModel as $productId) {
            $productIds[] = $productId->getProductEntityId();
        }
        // set the filters with required product ids.
        $collection->addAttributeToFilter('entity_id', array('in' => $productIds));
        // Little Housekeeping
        unset($ffModel);
        // Set Page size
        $collection->setPageSize(20)->setCurPage($currentPage);
        return $collection;
    }

    /**
     * Function prepares array with urls, attributes options ids and labels for next step
     *
     * @return mixed
     */
    public function prepareNextStepData()
    {
        // Get the Current Store ID
        $storeId = Mage::app()->getStore()->getId();
        $steps = $this->steps;
        $nextStep = array_slice($steps, $this->currentStep, 1);
        $nextStep = array_keys($nextStep);
        $nextStep = $nextStep[0];
        $steps = array_slice($steps, 0, $this->currentStep);
        $options = $this->prepareOptions($nextStep);
        $collection = Mage::getModel('lyonscg_filterfinder/filterfinder')
                ->getCollection();
        foreach ($steps as $key => $value) {
            $attributeId = $this->getAttributeOptionId($key, $value);
            if (!is_null($attributeId)) {
                $collection->addFieldToFilter($key, array('eq' => $attributeId));
            }
        }

        // Filter by store id.
        $collection->addFieldToFilter('website_id', $storeId);
        $collection->addFieldToSelect($nextStep);

        // Make sure to set disctinct to true.
        $collection->getSelect()
                ->reset(Zend_Db_Select::COLUMNS)
                ->columns($nextStep)
                ->distinct(true);
        $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
        $optionsSelected = $connection->fetchCol($collection->getSelect());
        $optionsWithLabels = $this->buildOptions($optionsSelected, $options);

        return $this->addImagesToOptions($optionsWithLabels);
    }

    /**
     * Function prepares array with urls, attributes options ids and labels for all steps
     *
     * @return array
     */
    public function prepareAllStepsData()
    {
        // Get the Current Store ID
        $storeId = Mage::app()->getStore()->getId();
        $steps = $this->steps;
        // This is necessary to build the query properly
        $tempSteps = $this->steps;
        $i = 0;

        foreach ($steps as $key => $value) {
            $options = $this->prepareOptions($key);
            $attributeId = $this->getAttributeOptionId($key, $value);

            // Start the collection fresh each time.
            $collection = Mage::getModel('lyonscg_filterfinder/filterfinder')
                    ->getCollection();
            // Incrementer required in building the query.
            $counter = 0;
            // Loop through each steps and create the correct query for each steps.
            // This is necessary when someone lands on a preselected url
            // or the page is refreshed.
            foreach ($tempSteps as $tempKey => $tempValue) {
                if ($counter < $i) {
                    $tempId = $this->getAttributeOptionId($tempKey, $tempValue);
                    if (!is_null($tempId) && $tempId !== '') {
                        $collection->addFieldToFilter($tempKey, array('eq' => $tempId));
                    }
                } else {
                    $collection->addFieldToFilter($tempKey, array('notnull' => 1));
                    break;
                }
                $counter++;
            }
            // Filter By store id.
            $collection->addFieldToFilter('website_id', $storeId);

            // Reset the Select column names and add Distinct for that column.
            $collection->getSelect()
                    ->reset(Zend_Db_Select::COLUMNS)
                    ->columns($key)
                    ->distinct(true);
            
            $connection = Mage::getSingleton('core/resource')->getConnection('core_read');
            $optionsSelected = $connection->fetchCol($collection->getSelect());
            $optionsWithLabels = $this->buildOptions($optionsSelected, $options);

            $steps[$key] = $this->addImagesToOptions($optionsWithLabels);
            if (is_null($value) || $value == '') {
                break;
            }
            // Make sure to clear the collection query.
            // we do not want any left overs.
            unset($collection);
            $i++;
        }

        return $steps;
    }

    /**
     * The following method returns the label for brand from it's id
     * which is being passed in the url.  If the id does not match it
     * returns null.
     *
     * @param string $key
     * @return string|null
     */
    public function getOptionIdByLabel($key, $code)
    {
        $productModel = Mage::getModel('catalog/product');
        $attr = $productModel->getResource()->getAttribute($key);
        if ($attr->usesSource()) {
            $optionsArray = $attr->getSource()->getAllOptions(false);
            foreach ($optionsArray as $option) {
                if ($option['label'] === $code) {
                    return $option['value'];
                }
            }
        }
        return NULL;
    }

    /**
     * Current function merges info from all possible options list
     * of the attribute with options that were taken from product collection
     *
     * @param array $optionsBad
     * @param array $options
     * @return array
     */
    public function buildOptions(array $optionsBad, array $options)
    {
        $optionsGood = array();
        foreach ($optionsBad as $idString) {
            $optionsIds = explode(',', $idString);
            foreach ($optionsIds as $optionId) {
                if (isset($options[$optionId])) {
                    $optionsGood[$optionId] = $options[$optionId];
                }
            }
        }

        return $optionsGood;
    }

    /**
     * Function adds images urls to attributes options
     *
     * @param string $nextStepData
     * @return mixed
     */
    public function addImagesToOptions($nextStepData)
    {
        foreach ($nextStepData as $key => $value) {
            $nextStepData[$key] = array('label' => $value,
                'imgUrl' => Mage::helper('attributeoptionimage')
                    ->getAttributeOptionImage($key));
        }
        return $nextStepData;
    }

    /**
     * Function returns all options for attribute with code $attrCode
     *
     * @param string $attrCode
     * @return array
     */
    public function prepareOptions($attrCode)
    {
        $result = array();
        $attribute = Mage::getModel('catalog/product')
                ->getResource()->getAttribute($attrCode);
        $options = $attribute->getSource()->getAllOptions();
        foreach ($options as $option) {
            if ($option['label'] != "") {
                $result[$option['value']] = $option['label'];
            }
        }
        return $result;
    }

    /**
     * Function inits currentStep and nextStep class variables
     *
     * @return void
     */
    public function getCurrentStep()
    {
        foreach ($this->steps as $key => $step) {
            if ($step !== NULL) {
                $this->currentStep++;
            } else {
                $this->nextStep = $key;
                break;
            }
        }
    }

    /**
     * Returns valid url for all attributes options
     *
     * @param string $label
     * @param string $code
     * @return string
     */
    public function getOptionUrl($label, $code = null)
    {
        if (null === $this->_secureFrontend) {
            $this->_secureFrontend = Mage::app()->getStore()->isCurrentlySecure();
        }

        $_params = Mage::getUrl('FridgeFilterFinder/index/step', array('_secure' => $this->_secureFrontend)) . '?';
        foreach ($this->steps as $key => $step) {
            if (($step !== NULL) && $key != $code) {
                $_params .= $key . '=' . urlencode($step) . '&';
            } else {
                $_params .= $key . '=' . urlencode($label);
                break;
            }
        }
        return $_params;
    }

    /**
     * Get ids for filter finder attributes
     *
     * @return array
     */
    public function getFilterFinderIds()
    {
        $ids = array();
        $eavAttribute = new Mage_Eav_Model_Mysql4_Entity_Attribute();
        foreach ($this->steps as $code => $value) {
            $id = $eavAttribute->getIdByCode('catalog_product', $code);
            if ($id) {
                $ids[] = $id;
            }
        }
        return $ids;
    }

    /**
     * Get 4 attributes filters
     *
     * @return array
     */
    public function getFilters()
    {
        $filters = array();
        foreach ($this->steps as $code => $value) {
            $attributeDetails = Mage::getSingleton("eav/config")
                    ->getAttribute('catalog_product', $code);
            if ($attributeDetails) {
                $filters[$code] = $attributeDetails;
            }
        }
        return $filters;
    }

    /**
     * Prepares data for ajax response in dependency of current state
     *
     * @return array|string|void
     */
    public function toGetJson()
    {
        if ($this->currentStep == 4) {
            return false;
        } else {
            $forJson = array();
            $nextStepOptions = $this->prepareNextStepData();
            foreach ($nextStepOptions as $option) {
                $option['linkUrl'] = $this->getOptionUrl($option['label']);
                $forJson[] = $option;
            }
            return json_encode($forJson);
        }
    }

}
