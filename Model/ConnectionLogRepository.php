<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Model;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\NoSuchEntityException;
use MyCompany\CustomerConnexionLogs\Model\ResourceModel\ConnectionLog as Resource;
use Magento\Framework\Exception\CouldNotSaveException;
use MyCompany\CustomerConnexionLogs\Api\ConnectionLogRepositoryInterface;
use MyCompany\CustomerConnexionLogs\Api\Data\ConnectionLogInterface;
use MyCompany\CustomerConnexionLogs\Api\Data\ConnectionLogInterfaceFactory;

class ConnectionLogRepository implements ConnectionLogRepositoryInterface
{
    private Resource $resource;
    private ConnectionLogInterfaceFactory $connectionLogFactory;

    public function __construct(
        Resource $resource,
        ConnectionLogInterfaceFactory $connectionLogFactory
    ) {
        $this->resource = $resource;
        $this->connectionLogFactory = $connectionLogFactory;
    }

    public function save(ConnectionLogInterface $connectionLog): ConnectionLogInterface
    {
        try {
            $this->resource->save($connectionLog);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(__($e->getMessage()));
        }

        return $connectionLog;
    }

    public function getById(int $entityId): ConnectionLogInterface
    {
        /** @var ConnectionLog $connectionLog */
        $connectionLog = $this->connectionLogFactory->create();
        $this->resource->load($connectionLog, $entityId);
        if (!$connectionLog->getId()) {
            $message = __('The Customer Connection Log entry with id "%1" does not exist', $entityId);
            throw new NoSuchEntityException($message);
        }

        return $connectionLog;
    }

    public function delete(ConnectionLogInterface $connectionLog): bool
    {
        try {
            $this->resource->delete($connectionLog);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__($e->getMessage()));
        }

        return true;
    }
}
