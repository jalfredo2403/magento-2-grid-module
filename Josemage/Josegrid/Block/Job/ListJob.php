<?php

namespace Josemage\Josegrid\Block\Job;


class ListJob extends \Magento\Framework\View\Element\Template
{

    /**
     * @var \Josemage\Josegrid\Model\Job
     */
    protected $_job;

    /**
     * @var \Josemage\Josegrid\Model\Department
     */
    protected $_department;

    /**
     * @var \Magento\Framework\App\ResourceConnection
     */
    protected $_resource;

    /**
     * @var null
     */
    protected $_jobCollection = null;

    /**
     * @var \Josemage\Josegrid\Model\ResourceModel\Department
     */
    protected  $departmentResourceModel;

    /**
     * @var \Josemage\Josegrid\Model\ResourceModel\Job\CollectionFactory
     */
    protected $jobCollectionFactory;


    /**
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param \Josemage\Josegrid\Model\Job $job
     * @param \Josemage\Josegrid\Model\Department $department
     * @param \Josemage\Josegrid\Model\ResourceModel\Job\CollectionFactory $jobCollectionFactory
     * @param \Josemage\Josegrid\Model\ResourceModel\Department $departmentResourceModel
     * @param \Magento\Framework\App\ResourceConnection $resource
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Josemage\Josegrid\Model\Job $job,
        \Josemage\Josegrid\Model\Department $department,
        \Josemage\Josegrid\Model\ResourceModel\Job\CollectionFactory $jobCollectionFactory,
        \Josemage\Josegrid\Model\ResourceModel\Department $departmentResourceModel,
        \Magento\Framework\App\ResourceConnection $resource,
        array $data = []
    ) {
        $this->_job = $job;
        $this->_department = $department;
        $this->_resource = $resource;
        $this->jobCollectionFactory = $jobCollectionFactory;
        $this->departmentResourceModel = $departmentResourceModel;

        parent::__construct(
            $context,
            $data
        );
    }


    /**
     * @return $this|ListJob
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();

        $title = __('We are hiring');
        $description = __('Look at the jobs we have got for you');
        $keywords = __('job,hiring');

        $this->getLayout()->createBlock('Magento\Catalog\Block\Breadcrumbs');

        if ($breadcrumbsBlock = $this->getLayout()->getBlock('breadcrumbs')) {
            $breadcrumbsBlock->addCrumb(
                'jobs',
                [
                    'label' => $title,
                    'title' => $title,
                    'link' => false // No link for the last element
                ]
            );
        }

        $this->pageConfig->getTitle()->set($title);
        $this->pageConfig->setDescription($description);
        $this->pageConfig->setKeywords($keywords);


        $pageMainTitle = $this->getLayout()->getBlock('page.main.title');
        if ($pageMainTitle) {
            $pageMainTitle->setPageTitle($title);
        }

        return $this;
    }

    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    protected function _getJobCollection()
    {
        if ($this->_jobCollection === null) {
            $jobCollection = $this->jobCollectionFactory->create()
                ->addFieldToSelect('*')
                ->join(
                    array('department' => $this->departmentResourceModel->getMainTable()),
                    'main_table.department_id = department.'.$this->_job->getIdFieldName(),
                    array('department_name' => 'name')
                );
            $this->_jobCollection = $jobCollection;
        }
        return $this->_jobCollection;
    }


    /**
     * @return \Magento\Framework\Data\Collection\AbstractDb|\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection|null
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getLoadedJobCollection()
    {
        return $this->_getJobCollection();
    }

    /**
     * @param $job
     * @return string
     */
    public function getJobUrl($job){
        if(!$job->getId()){
            return '#';
        }

        return $this->getUrl('jobs/job/view', ['id' => $job->getId()]);
    }

    /**
     * @param $job
     * @return string
     */
    public function getDepartmentUrl($job){
        if(!$job->getDepartmentId()){
            return '#';
        }

        return $this->getUrl('jobs/department/view', ['id' => $job->getDepartmentId()]);
    }
}
