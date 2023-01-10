<?php declare(strict_types=1);

namespace MyCompany\CustomerConnexionLogs\Model\ResourceModel\ConnectionLog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MyCompany\CustomerConnexionLogs\Model\ConnectionLog as Model;
use MyCompany\CustomerConnexionLogs\Model\ResourceModel\ConnectionLog as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'customer_connexion_logs_collection';

    /**
     * Initialize collection model.
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
