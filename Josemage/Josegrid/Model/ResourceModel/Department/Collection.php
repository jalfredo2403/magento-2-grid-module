<?php
namespace Josemage\Josegrid\Model\ResourceModel\Department;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = \Josemage\Josegrid\Model\Department::DEPARTMENT_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Josemage\Josegrid\Model\Department', 'Josemage\Josegrid\Model\ResourceModel\Department');
    }

}
