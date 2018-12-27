<?php

namespace Chebotaryoff\CustomerStatus\Block;

use Magento\Framework\View\Element\Template\Context;
use Magento\Customer\Model\Session;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Chebotaryoff\CustomerStatus\ViewModel\Customer;

/**
 * Html page header block
 *
 * @api
 * @since 100.0.2
 */
class Header extends \Magento\Theme\Block\Html\Header
{
    /**
     * Current template name
     *
     * @var string
     */
    protected $_template = 'Chebotaryoff_CustomerStatus::header_info.phtml';

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var CustomerRepositoryInterface
     */
    protected $customerRepository;

    /**
     * @var Customer
     */
    protected $customerModel;

    public function __construct(
        Context $context,
        Session $customerSession,
        CustomerRepositoryInterface $customerRepository,
        Customer $customerModel,
        array $data = []
    )
    {
        parent::__construct($context, $data);
        $this->session = $customerSession;
        $this->customerRepository = $customerRepository;
        $this->customerModel = $customerModel;
    }

    public function getCustomerStatus()
    {
        return $this->customerModel->getCustomerStatus();
    }

}
