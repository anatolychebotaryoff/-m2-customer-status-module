<?php
/**
 * Rewrite Magemaven_OrderComment_Model_Observer
 *
 * @category  Lyons
 * @package   Lyonscg_OrderComment
 * @author    Mark Hodge <mhodge@lyonscg.com>
 * @copyright 2014 Lyons Consulting Group (www.lyonscg.com)
 */ 
class Lyonscg_OrderComment_Model_Observer extends Magemaven_OrderComment_Model_Observer
{
    /**
     * Rewrite to check for onestepcheckout_comments
     * Save comment from agreement form to order
     *
     * @param $observer
     */
    public function saveOrderComment($observer)
    {
        $orderComment = Mage::app()->getRequest()->getPost('ordercomment');
        $oneStepCheckoutOrderComment = Mage::app()->getRequest()->getPost('onestepcheckout_comments');
        $order = $observer->getEvent()->getOrder();
        if (is_array($orderComment) && isset($orderComment['comment'])) {
            $comment = trim($orderComment['comment']);

            if (!empty($comment)) {
                $order->setCustomerComment($comment);
                $order->setCustomerNoteNotify(true);
                $order->setCustomerNote($comment);
            }
        } else if (!empty($oneStepCheckoutOrderComment)) {
            $order->setCustomerComment($oneStepCheckoutOrderComment);
            $order->setCustomerNoteNotify(true);
            $order->setCustomerNote($oneStepCheckoutOrderComment);
        }
    }
}
