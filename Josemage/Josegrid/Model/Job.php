<?php
namespace Josemage\Josegrid\Model;

use \Magento\Framework\Model\AbstractModel;

class Job extends AbstractModel
{
    /**
     * id fieldname
     */
    const JOB_ID = 'entity_id';

    /**
     *
     */
    const JOB_ENABLED_STATUS = 1;

    /**
     *
     */
    const JOB_DISABLED_STATUS = 0;

    /**
     * Prefix of model events names
     *
     * @var string
     */
    protected $_eventPrefix = 'jobs';

    /**
     * Name of the event object
     *
     * @var string
     */
    protected $_eventObject = 'job';

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = self::JOB_ID;

    /**
     * Initialize resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Josemage\Josegrid\Model\ResourceModel\Job');
    }

    /**
     * @return int
     */
    public function getEnableStatus() {
        return self::JOB_ENABLED_STATUS;
    }

    /**
     * @return int
     */
    public function getDisableStatus() {
        return self::JOB_DISABLED_STATUS;
    }
}
