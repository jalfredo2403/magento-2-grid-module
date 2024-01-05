<?php
namespace Josemage\Josegrid\Model\ResourceModel\Job;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{

    protected $_idFieldName = \Josemage\Josegrid\Model\Job::JOB_ID;

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Josemage\Josegrid\Model\Job', 'Josemage\Josegrid\Model\ResourceModel\Job');
    }

}
