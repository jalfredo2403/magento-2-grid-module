<?php
namespace Josemage\Josegrid\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

/**
 * Department post mysql resource
 */
class Department extends AbstractDb
{
    /**
     *
     */
    const MAIN_TABLE = "josegrid_department";

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        // Table Name and Primary Key column
        $this->_init(static::MAIN_TABLE, 'entity_id');
    }

    /**
     * @return string
     */
    public function getMainTable()
    {
        return static::MAIN_TABLE;
    }
}
