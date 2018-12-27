<?php

namespace Chebotaryoff\CustomerStatus\ViewModel;

use Magento\Customer\Model\Session;
use Magento\Framework\UrlInterface;
use Magento\Customer\Api\CustomerRepositoryInterface;

class Customer implements \Magento\Framework\View\Element\Block\ArgumentInterface
{
    /**
     * @var \Magento\Framework\UrlInterface
     */
    protected $urlBuilder;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    public function __construct(
        UrlInterface $urlBuilder,
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->session = $customerSession;
        $this->customerRepository = $customerRepository;
    }

    public function getFormUrl()
    {
        return $this->urlBuilder->getUrl('customerstatus/index/savePost');
    }

    public function getCustomerStatus()
    {
        $customer = $this->customerRepository->getById($this->session->getCustomerId());
        $attribute = $customer->getCustomAttribute('customer_status');
        if(isset($attribute)) {
            return $attribute->getValue();
        }
        return false;
    }
}