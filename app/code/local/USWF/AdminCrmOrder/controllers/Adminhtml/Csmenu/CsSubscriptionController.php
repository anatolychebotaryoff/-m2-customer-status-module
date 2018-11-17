<?php

class USWF_AdminCrmOrder_Adminhtml_Csmenu_CsSubscriptionController extends Mage_Adminhtml_Controller_Action {

    public function changeSubscriptionAction()
    {
        try {
            // Get POST data
            $request = $this->getRequest()->getPost();
            $customer_id = $request['customer_id'];

            // Get customer
            $customer = Mage::getModel('customer/customer')->load($customer_id);

            // Call platform to get subscription(s)
            if($request['subscription_id'] == 'all_active') {
                $subscriptions = Mage::helper('autoship/platform')->getSubscriptions(
                    $customer,
                    array(
                        'status' => 'Active',
                    ));
                $firstSubscription = $subscriptions[0];
            }
            else {
                $firstSubscription = Mage::helper('autoship/platform')->getSubscription($request['subscription_id']);
                $subscriptions[] = $firstSubscription;

                // Modify qty, interval
                if (isset($request['interval'])) {
                    $firstSubscription->setInterval($request['interval']);
                }
                if (isset($request['qty'])) {
                    $firstSubscription->setQty($request['qty']);
                }
            }

            // Modify next order date
            if (isset($request['delivery_date'])) {
                foreach($subscriptions as $subscription) {
                    $subscription->setNextOrderDate($request['delivery_date']);
                }
            }
            // Send changes to platform
            foreach($subscriptions as $subscription) {
                $newSubscriptionId = Mage::helper('autoship/platform')->updateSubscription($subscription->getSubscriptionId(), $subscription);
            }
            // Return the rendered html for this new subscription state
            if($request['subscription_id'] == 'all_active') {
                //TODO echo json
      //          echo $this->getLayout()->createBlock('autoship/mysubscriptions')
       //             ->setTemplate('autoship/mysubscriptions.phtml')
       //             ->toHtml();
            }
            else {
                //TODO echo json
                //     echo $this->getLayout()->createBlock('autoship/mysubscriptions_subscription')
           //         ->setTemplate('autoship/mysubscriptions/subscription.phtml')
            //        ->setSubscription($firstSubscription)
            //        ->toHtml();
            }
        }
        catch (Exception $e) {
            $this->getResponse()->setBody( $e->getMessage() );
        }
    }

    /**
     * Skip the next delivery action
     */
    public function skipAction()
    {
        /** @var SFC_Autoship_Helper_Platform $platformHelper */
        $platformHelper = Mage::helper('autoship/platform');
        try {
            // Get subscription id from request
            $subscriptionId = $this->getRequest()->getParam('id');
            // Call API to delete subscription
            $platformHelper->skipSubscription($subscriptionId);
            // Now call platform to get subscription again
            $subscription = $platformHelper->getSubscription($subscriptionId);
            // Return the rendered html for this new subscription state
            $this->getResponse()->setBody( $this->getLayout()->createBlock('autoship/mysubscriptions_subscription')
                ->setTemplate('autoship/mysubscriptions/subscription.phtml')
                ->setSubscription($subscription)
                ->toHtml());
        }
        catch (Exception $e) {
            $this->handleAjaxException($e);
        }
    }

    /**
     * Cancel subscription action
     *
     */
    public function cancelAction()
    {
        /** @var SFC_Autoship_Helper_Platform $platformHelper */
        $platformHelper = Mage::helper('autoship/platform');
        try {
            // Get subscription id from request
            $subscriptionId = $this->getRequest()->getParam('id');
            // Call API to delete subscription
            $platformHelper->cancelSubscription($subscriptionId);
            // Now call platform to get subscription again
            $subscription = $platformHelper->getSubscription($subscriptionId);
            // Return the rendered html for this new subscription state
    //        echo $this->getLayout()->createBlock('autoship/mysubscriptions_subscription')
       //         ->setTemplate('autoship/mysubscriptions/subscription.phtml')
        //        ->setSubscription($subscription)
        //        ->toHtml();
        }
        catch (Exception $e) {
            $this->handleAjaxException($e);
        }
    }

    /**
     * Pause subscription action
     *
     */
    public function pauseAction()
    {
        /** @var SFC_Autoship_Helper_Platform $platformHelper */
        $platformHelper = Mage::helper('autoship/platform');
        try {
            // Get subscription id from request
            $subscriptionId = $this->getRequest()->getParam('id');
            // Call API to delete subscription
            $platformHelper->pauseSubscription($subscriptionId);
            // Now call platform to get subscription again
            $subscription = $platformHelper->getSubscription($subscriptionId);
            // Return the rendered html for this new subscription state
        //    echo $this->getLayout()->createBlock('autoship/mysubscriptions_subscription')
        //        ->setTemplate('autoship/mysubscriptions/subscription.phtml')
         //       ->setSubscription($subscription)
          //      ->toHtml();
        }
        catch (Exception $e) {
            $this->handleAjaxException($e);
        }
    }

    /**
     * Restart subscription action
     *
     */
    public function restartAction()
    {
        /** @var SFC_Autoship_Helper_Platform $platformHelper */
        $platformHelper = Mage::helper('autoship/platform');
        try {
            // Get subscription id from request
            $subscriptionId = $this->getRequest()->getParam('id');
            // Call API to delete subscription
            $platformHelper->restartSubscription($subscriptionId);
            // Now call platform to get subscription again
            $subscription = $platformHelper->getSubscription($subscriptionId);
            // Return the rendered html for this new subscription state
       //     echo $this->getLayout()->createBlock('autoship/mysubscriptions_subscription')
        //        ->setTemplate('autoship/mysubscriptions/subscription.phtml')
        //        ->setSubscription($subscription)
         //       ->toHtml();
        }
        catch (Exception $e) {
            $this->handleAjaxException($e);
        }
    }

}
