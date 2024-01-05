<?php namespace Josemage\Josegrid\Setup;

use Josemage\Josegrid\Model\Department;
use Josemage\Josegrid\Model\Job;
use Magento\Framework\Setup\UpgradeDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;

/**
 * @codeCoverageIgnore
 */
class UpgradeData implements UpgradeDataInterface
{

    protected $_department;
    protected $_job;

    public function __construct(Department $department, Job $job){
        $this->_department = $department;
        $this->_job = $job;
    }

    /**
     * {@inheritdoc}
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    public function upgrade(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;
        $installer->startSetup();

        // Action to do if module version is less than 1.0.0.2
        if (version_compare($context->getVersion(), '1.0.0.1') < 0) {
            $departments = [
                [
                    'name' => 'Marketing',
                    'description' => 'Marketing description.'
                ],
                [
                    'name' => 'Technical Support',
                    'description' => 'Technical Support description.'
                ],
                [
                    'name' => 'Human Resource',
                    'description' => 'Human Resource description.'
                ]
            ];

            /**
             * Insert departments
             */
            $departmentsIds = array();
            foreach ($departments as $data) {
                $department = $this->_department->setData($data)->save();
                $departmentsIds[] = $department->getId();
            }


            $jobs = [
                [
                    'title' => 'Sample Marketing Job 1',
                    'type' => 'CDI',
                    'location' => 'Ga, USA',
                    'date'  => '2016-01-05',
                    'status' => $this->_job->getEnableStatus(),
                    'description' => 'Sample Marketing Job 1 Descriptions.',
                    'department_id' => $departmentsIds[0]
                ],
                [
                    'title' => 'Sample Marketing Job 2',
                    'type' => 'CDI',
                    'location' => 'Ga, USA',
                    'date'  => '2020-01-10',
                    'status' => $this->_job->getDisableStatus(),
                    'description' => 'Sample Marketing Job 2 description.',
                    'department_id' => $departmentsIds[0]
                ],
                [
                    'title' => 'Sample Technical Support Job 1',
                    'type' => 'CDD',
                    'location' => 'Fl, USA',
                    'date'  => '2019-02-01',
                    'status' => $this->_job->getEnableStatus(),
                    'description' => 'Sample Technical Support Job 1 description.',
                    'department_id' => $departmentsIds[1]
                ],
                [
                    'title' => 'Sample Human Resource Job 1',
                    'type' => 'CDI',
                    'location' => 'Paris, France',
                    'date'  => '2016-01-01',
                    'status' => $this->_job->getEnableStatus(),
                    'description' => 'Sample Human Resource Job 1 description',
                    'department_id' => $departmentsIds[2]
                ]
            ];

            foreach ($jobs as $data) {
                $this->_job->setData($data)->save();
            }
        }

        $installer->endSetup();
    }
}
