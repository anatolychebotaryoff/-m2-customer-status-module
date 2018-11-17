<?php
/**
 * USWF Parameter Dispatch Event
 *
 * @category    USWF
 * @package     USWF_ParameterDispatch
 * @author      Cliff Coffee (cliff.coffee@commercialwaterdistributing.com)
 * @copyright   Copyright (c) 2015 Commercial Water Distributing (www.commercialwaterdistributing.com)
 */

class USWF_ParameterDispatch_Model_Observer
{

    public function onControllerActionPredispatch($observer)
    {

        $params = Mage::app()->getRequest()->getParams();

        if (
            $params &&
            Mage::app()->getRequest()->isGet() &&
            !Mage::app()->getRequest()->isAjax() 
        ) {

            $event_model = Mage::getModel('uswf_parameterdispatch/event');
            
            $event_collection = $event_model->getCachedCollection();

            foreach ($event_collection as $event) {

                if (array_key_exists($event["param"], $params)) {
                    $this->fireEvent($event, $observer);
                }

            }

        }        

    }

    private function fireEvent($event, $observer) {

        Mage::dispatchEvent($event["event"], (array) $observer); 

    }

}
