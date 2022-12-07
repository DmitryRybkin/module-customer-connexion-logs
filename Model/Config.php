<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

class Config
{
    private const XML_PATH_CUSTOMER_CONNECTION_LOG_GENERAL_ENABLED = 'customer_connection_log/general/enabled';

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
}
