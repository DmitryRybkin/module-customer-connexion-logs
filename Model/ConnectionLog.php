<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Model;

use Magento\Framework\Model\AbstractModel;
use MyCompany\CustomerConnexionLogs\Api\Data\ConnectionLogInterface;
use MyCompany\CustomerConnexionLogs\Model\ResourceModel\ConnectionLog as ResourceModel;

class ConnectionLog extends AbstractModel implements ConnectionLogInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'customer_connexion_logs_model';

    /**
     * Initialize magento model.
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    public function getCustomerId(): int
    {
        return (int)$this->_getData(self::CUSTOMER_ID);
    }

    public function setCustomerId($customerId): ConnectionLog
    {
        return $this->setData(self::CUSTOMER_ID, $customerId);
    }

    public function getIp(): string
    {
        return $this->_getData(self::IP);
    }

    public function setIp($ip): ConnectionLog
    {
        return $this->setData(self::IP, $ip);
    }

    public function getCreatedAt(): string
    {
        return $this->_getData(self::CREATED_AT);
    }

    public function setCreatedAt($createdAt): ConnectionLog
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }

    public function getUpdatedAt(): string
    {
        return $this->_getData(self::UPDATED_AT);
    }

    public function setUpdatedAt($updatedAt): ConnectionLog
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }
}
