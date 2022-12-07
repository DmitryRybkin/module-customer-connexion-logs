<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Api;

use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use MyCompany\CustomerConnexionLogs\Api\Data\ConnectionLogInterface;

interface ConnectionLogRepositoryInterface
{
    /**
     * @throws  CouldNotSaveException
     */
    public function save(ConnectionLogInterface $connectionLog): ConnectionLogInterface;

    /**
     * @throws NoSuchEntityException
     */
    public function getById(int $entityId): ConnectionLogInterface;

    /**
     * @throws CouldNotDeleteException
     */
    public function delete(ConnectionLogInterface $connectionLog): bool;
}
