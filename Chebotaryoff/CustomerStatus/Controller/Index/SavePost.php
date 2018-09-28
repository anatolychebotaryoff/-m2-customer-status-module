<?php

namespace Chebotaryoff\CustomerStatus\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\Data\Form\FormKey\Validator;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;

class SavePost extends \Magento\Framework\App\Action\Action
{

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var Validator
     */
    protected $formKeyValidator;

    /**
     * @var Session
     */
    protected $session;

    /**
     * SavePost constructor.
     * @param Context $context
     * @param Session $customerSession
     * @param CustomerRepositoryInterface $customerRepository
     * @param Validator $formKeyValidator
     */
    public function __construct(
        Context $context,
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository,
        Validator $formKeyValidator
    ) {
        parent::__construct($context);
        $this->session = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->formKeyValidator = $formKeyValidator;
    }

    /**
     * Change customer status
     *
     * @return \Magento\Framework\Controller\Result\Redirect
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $validFormKey = $this->formKeyValidator->validate($this->getRequest());

        if ($validFormKey && $this->getRequest()->isPost()) {
            $customer = $this->customerRepository->getById($this->session->getCustomerId());
            $customerStatus = $this->getRequest()->getParam('customer_status');
            if(isset($customerStatus)) {
                try {
                    $customer->setCustomAttribute('customer_status', $customerStatus);
                    $this->customerRepository->save($customer);
                    $this->messageManager->addSuccessMessage(__('You saved the customer status.'));
                    return $resultRedirect->setPath('customer/account');
                }
                catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e->getMessage());
                }

            }
        }

        return $resultRedirect->setPath('customerstatus');
    }
}