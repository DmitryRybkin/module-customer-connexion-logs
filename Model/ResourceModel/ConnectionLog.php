<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ConnectionLog extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'customer_connexion_logs_resource_model';

    /**
     * Initialize resource model.
     */
    protected function _construct()
    {
        $this->_init('customer_connexion_logs', 'entity_id');
        $this->_useIsObjectNew = true;
    }
}
