<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Api\Data;

/**
 * Customer ConnexionLogs interface
 * @api
 * @since 1.0.0
 */
interface ConnectionLogInterface
{
    public const ENTITY_ID = 'id';
    public const CUSTOMER_ID = 'customer_id';
    public const IP = 'ip';
    public const CREATED_AT = 'created_at';
    public const UPDATED_AT = 'updated_at';

    /**
     * @return int
     */
    public function getEntityId();

    /**
     * @param int $id
     * @return $this
     */
    public function setEntityId($id);

    /**
     * @return int
     */
    public function getCustomerId();

    /**
     * @param int $customerId
     * @return $this
     */
    public function setCustomerId($customerId);

    /**
     * @return string
     */
    public function getIp();

    /**
     * @param string $ip
     * @return $this
     */
    public function setIp($ip);

    /**
     * @return string
     */
    public function getCreatedAt();

    /**
     * @param int $createdAt
     * @return $this
     */
    public function setCreatedAt($createdAt);

    /**
     * @return string
     */
    public function getUpdatedAt();

    /**
     * @param int $updatedAt
     * @return $this
     */
    public function setUpdatedAt($updatedAt);
}
