<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_CUSTOMER_CONNECTION_LOG_GENERAL_ENABLED = 'customer_connection_log/general/enabled';
    private const XML_PATH_CUSTOMER_CONNECTION_LOG_EMAIL = 'customer_connection_log/general/tracker_email_template';
    private const XML_PATH_CUSTOMER_CONNECTION_LOG_EMAIL_RECIPIENT = 'customer_connection_log/general/recipient';

    private const XML_PATH_ADMIN_GENERAL_STORE_NAME = 'trans_email/ident_general/name';
    private const XML_PATH_ADMIN_GENERAL_STORE_EMAIL = 'trans_email/ident_general/email';

    private ScopeConfigInterface $scopeConfig;

    public function __construct(
        ScopeConfigInterface $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
    }

    public function isCustomerLogTrackingEnabled(string $storeId = null): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_CUSTOMER_CONNECTION_LOG_GENERAL_ENABLED,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getEmailTrackerTemplate($storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_CONNECTION_LOG_EMAIL,
            ScopeInterface::SCOPE_STORES,
            $storeId
        );
    }

    public function getSenderName($storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_ADMIN_GENERAL_STORE_NAME,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getSenderEmail($storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_ADMIN_GENERAL_STORE_EMAIL,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }

    public function getRecipientEmail($storeId = null): string
    {
        return (string)$this->scopeConfig->getValue(
            self::XML_PATH_CUSTOMER_CONNECTION_LOG_EMAIL_RECIPIENT,
            ScopeInterface::SCOPE_STORE,
            $storeId
        );
    }
}
