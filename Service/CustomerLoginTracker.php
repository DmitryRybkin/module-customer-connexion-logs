<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Service;

use Magento\Framework\Stdlib\DateTime as StdlibDateTime;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use Magento\Framework\Stdlib\DateTime\TimezoneInterface;
use MyCompany\CustomerConnexionLogs\Api\ConnectionLogRepositoryInterface;
use MyCompany\CustomerConnexionLogs\Api\Data\ConnectionLogInterface;
use MyCompany\CustomerConnexionLogs\Api\Data\ConnectionLogInterfaceFactory;
use MyCompany\CustomerConnexionLogs\Model\ResourceModel\ConnectionLog\Collection;
use MyCompany\CustomerConnexionLogs\Model\ResourceModel\ConnectionLog\CollectionFactory;
use Magento\Framework\Stdlib\DateTime\TimezoneInterfaceFactory;

class CustomerLoginTracker
{
    private ConnectionLogInterfaceFactory $connectionLogFactory;
    private ConnectionLogRepositoryInterface $connectionLogRepository;
    private RemoteAddress $remoteAddress;
    private CollectionFactory $collectionFactory;
    private TimezoneInterfaceFactory $timezoneInterfaceFactory;

    public function __construct(
        ConnectionLogInterfaceFactory $connectionLogFactory,
        ConnectionLogRepositoryInterface $connectionLogRepository,
        RemoteAddress $remoteAddress,
        CollectionFactory $collectionFactory,
        TimezoneInterfaceFactory $timezoneInterfaceFactory,
    ) {
        $this->connectionLogFactory = $connectionLogFactory;
        $this->connectionLogRepository = $connectionLogRepository;
        $this->remoteAddress = $remoteAddress;
        $this->collectionFactory = $collectionFactory;
        $this->timezoneInterfaceFactory = $timezoneInterfaceFactory;
    }

    /**
     * @throws CouldNotSaveException
     */
    public function track(int $customerId): void
    {
        $connectionLog = $this->connectionLogFactory->create();
        $connectionLog->setCustomerId($customerId);
        if ($ip = $this->remoteAddress->getRemoteAddress()) {
            $connectionLog->setIp($ip);
        }

        $this->connectionLogRepository->save($connectionLog);
    }

    /**
     * @throws \Exception
     */
    public function getTotalConnexionCountForLastDay(): int
    {
        /** @var TimezoneInterface $timezone */
        $timezoneDate = $this->timezoneInterfaceFactory->create()
            ->date()
            ->format(StdlibDateTime::DATE_PHP_FORMAT);
        $currentDate = new \DateTime($timezoneDate);
        $lessThanDate = $currentDate->format(StdlibDateTime::DATETIME_PHP_FORMAT);
        $graterThanEqualDate = $currentDate->modify("-1 day")
            ->format(StdlibDateTime::DATETIME_PHP_FORMAT);

        /** @var Collection $collection */
        $collection = $this->collectionFactory->create()
            ->addFieldToFilter(
                ConnectionLogInterface::CREATED_AT,
                ['lt' => $lessThanDate]
            )
            ->addFieldToFilter(
                ConnectionLogInterface::CREATED_AT,
                ['gteq' => $graterThanEqualDate]
            );

        return $collection->count();
    }
}
