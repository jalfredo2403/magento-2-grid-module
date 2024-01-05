<?php
namespace Josemage\Josegrid\Controller\Adminhtml\Department;

use Magento\Backend\App\Action;
use \Josemage\Josegrid\Model\DepartmentFactory as DepartamentModelFactory;
use \Josemage\Josegrid\Model\ResourceModel\DepartmentFactory as DepartamentResourceModelFactory;

/**
 *
 */
class Edit extends Action
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $_resultPageFactory;

    /**
     * @var DepartamentModelFactory
     */
    protected $departamentModelFactory;

    /**
     * @var DepartamentResourceModelFactory
     */
    protected $departamentResourceModelFactory;

    /**
     * @param Action\Context $context
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param \Magento\Framework\Registry $registry
     * @param DepartamentModelFactory $departamentModelFactory
     * @param DepartamentResourceModelFactory $departamentResourceModelFactory
     */
    public function __construct(
        Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Registry $registry,
        DepartamentModelFactory $departamentModelFactory,
        DepartamentResourceModelFactory $departamentResourceModelFactory,
    ) {
        $this->_resultPageFactory = $resultPageFactory;
        $this->_coreRegistry = $registry;
        $this->departamentModelFactory = $departamentModelFactory;
        $this->departamentResourceModelFactory = $departamentResourceModelFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Josemage_Josegrid::department_save');
    }

    /**
     * Init actions
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    protected function _initAction()
    {
        // load layout, set active menu and breadcrumbs
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_resultPageFactory->create();
        $resultPage->setActiveMenu('Josemage_Josegrid::department')
            ->addBreadcrumb(__('Department'), __('Department'))
            ->addBreadcrumb(__('Manage Departments'), __('Manage Departments'));
        return $resultPage;
    }

    /**
     * Edit Department
     *
     * @return \Magento\Backend\Model\View\Result\Page| \Magento\Backend\Model\View\Result\Redirect
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        $model = $this->departamentModelFactory->create();
        $resourceModel = $this->departamentResourceModelFactory->create();
        // If you have got an id, it's edition
        if ($id) {
            $resourceModel->load($model, $id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This department not exists.'));
                /** \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();

                return $resultRedirect->setPath('*/*/');
            }
        }

        $data = $this->_getSession()->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

//        @TODO refactoring for not using registry and Register.
        $this->_coreRegistry->register('jobs_department', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->_initAction();
        $resultPage->addBreadcrumb(
            $id ? __('Edit Department') : __('New Department'),
            $id ? __('Edit Department') : __('New Department')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Departments'));
        $resultPage->getConfig()->getTitle()
            ->prepend($model->getId() ? $model->getName() : __('New Department'));

        return $resultPage;
    }
}
