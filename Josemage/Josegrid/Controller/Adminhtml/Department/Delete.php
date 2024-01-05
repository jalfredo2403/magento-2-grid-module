<?php
namespace Josemage\Josegrid\Controller\Adminhtml\Department;

use Magento\Backend\App\Action;
use \Josemage\Josegrid\Model\DepartmentFactory as DepartamentModelFactory;
use \Josemage\Josegrid\Model\ResourceModel\DepartmentFactory as DepartamentResourceModelFactory;

/**
 *
 */
class Delete extends Action
{

    /**
     * @var DepartamentModelFactory
     */
    protected $departamentModelFactory;

    /**
     * @var DepartamentResourceModelFactory
     */
    protected $departamentResourceModelFactory;


    /**
     * @param DepartamentModelFactory $departamentModelFactory
     * @param DepartamentResourceModelFactory $departamentResourceModelFactory
     * @param Action\Context $context
     */
    public function __construct(
        DepartamentModelFactory $departamentModelFactory,
        DepartamentResourceModelFactory $departamentResourceModelFactory,
        Action\Context $context,
    ) {
        $this->departamentModelFactory = $departamentModelFactory;
        $this->departamentResourceModelFactory = $departamentResourceModelFactory;
        parent::__construct($context);
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Maxime_Jobs::department_delete');
    }

    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            try {
                $model = $this->departamentModelFactory->create();
                $resourceModel = $this->departamentResourceModelFactory->create();
                $resourceModel->load($model, $id);
                $resourceModel->delete($model);
                $this->messageManager->addSuccessMessage(__('Department deleted'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        $this->messageManager->addErrorMessage(__('Department does not exist'));
        return $resultRedirect->setPath('*/*/');
    }
}
