<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\ViewModel;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Element\Block\ArgumentInterface;
use MyCompany\CustomerConnexionLogs\Api\Data\ConnectionLogInterface;
use MyCompany\CustomerConnexionLogs\Model\ResourceModel\ConnectionLog\Collection;
use MyCompany\CustomerConnexionLogs\Model\ResourceModel\ConnectionLog\CollectionFactory;

class CustomerConnectionInfo implements ArgumentInterface
{
    private RequestInterface $request;
    private CollectionFactory $collectionFactory;

    public function __construct(
        RequestInterface $request,
        CollectionFactory $collectionFactory
    ) {
        $this->request = $request;
        $this->collectionFactory = $collectionFactory;
    }

    public function getLastVisitedCustomerIp(): ?string
    {
        $customerId = $this->request->getParam('id');
        if (!$customerId) {
            return null;
        }

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        /** @var ConnectionLogInterface $connectionItem */
        $connectionItem = $collection->addFieldToFilter(ConnectionLogInterface::CUSTOMER_ID, $customerId)
            ->addFieldToSelect(ConnectionLogInterface::IP)
            ->addOrder('created_at')
            ->getFirstItem();

        return $connectionItem->getIp();
    }
}
