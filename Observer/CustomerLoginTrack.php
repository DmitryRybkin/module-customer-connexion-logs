<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Observer;

use Magento\Customer\Model\Customer;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use MyCompany\CustomerConnexionLogs\Model\Config;
use MyCompany\CustomerConnexionLogs\Service\CustomerLoginTracker;
use Psr\Log\LoggerInterface;

class CustomerLoginTrack implements ObserverInterface
{
    private Config $config;
    private CustomerLoginTracker $customerLoginTracker;
    private LoggerInterface $logger;

    public function __construct(
        Config $config,
        CustomerLoginTracker $customerLoginTracker,
        LoggerInterface $logger
    ) {
        $this->config = $config;
        $this->customerLoginTracker = $customerLoginTracker;
        $this->logger = $logger;
    }

    public function execute(Observer $observer): void
    {
        if (!$this->config->isCustomerLogTrackingEnabled()) {
            return;
        }

        /** @var Customer $customer */
        $customer = $observer->getData('customer');
        if (!$customer) {
            return;
        }

        try {
            $this->customerLoginTracker->track((int)$customer->getId());
        } catch (CouldNotSaveException $e) {
            $this->logger->error(__($e->getMessage()));
            return;
        }
    }
}
