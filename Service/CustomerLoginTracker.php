<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Service;

use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\HTTP\PhpEnvironment\RemoteAddress;
use MyCompany\CustomerConnexionLogs\Api\ConnectionLogRepositoryInterface;
use MyCompany\CustomerConnexionLogs\Api\Data\ConnectionLogInterfaceFactory;

class CustomerLoginTracker
{
    private ConnectionLogInterfaceFactory $connectionLogFactory;
    private ConnectionLogRepositoryInterface $connectionLogRepository;
    private RemoteAddress $remoteAddress;

    public function __construct(
        ConnectionLogInterfaceFactory $connectionLogFactory,
        ConnectionLogRepositoryInterface $connectionLogRepository,
        RemoteAddress $remoteAddress
    ) {
        $this->connectionLogFactory = $connectionLogFactory;
        $this->connectionLogRepository = $connectionLogRepository;
        $this->remoteAddress = $remoteAddress;
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
}
