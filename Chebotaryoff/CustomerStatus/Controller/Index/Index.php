<?php

namespace Chebotaryoff\CustomerStatus\Controller\Index;

class Index extends \Magento\Framework\App\Action\Action
{

    /**
     * @var \Magento\Customer\Model\Session
     */
    protected $customerSession;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Customer\Model\Session $customerSession
    ) {
        parent::__construct($context);
        $this->customerSession = $customerSession;
    }

    /**
     * @return void
     */
    public function execute()
    {

        if(!$this->customerSession->isLoggedIn()) {
            return $this->resultRedirectFactory->create()->setPath($this->_redirect->getRefererUrl());
        }

        $this->_view->loadLayout();
        $this->_view->getPage()->getConfig()->getTitle()->set(__('Customer Status'));
        $this->_view->renderLayout();
    }
}