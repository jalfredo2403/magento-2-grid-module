<?php
namespace Josemage\Josegrid\Controller\Adminhtml\Department;

use Magento\Backend\App\Action;
use \Josemage\Josegrid\Model\DepartmentFactory as DepartamentModelFactory;
use \Josemage\Josegrid\Model\ResourceModel\DepartmentFactory as DepartamentResourceModelFactory;

/**
 *
 */
class Save extends Action
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
     * @param Action\Context $context
     * @param \Josemage\Josegrid\Model\Department $model
     */
    public function __construct(
        Action\Context $context,
        DepartamentModelFactory $departamentModelFactory,
        DepartamentResourceModelFactory $departamentResourceModelFactory,
    ) {
        parent::__construct($context);
        $this->departamentModelFactory = $departamentModelFactory;
        $this->departamentResourceModelFactory = $departamentResourceModelFactory;
    }

    /**
     * {@inheritdoc}
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Josemage_Josegrid::department_save');
    }

    /**
     * Save action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $data = $this->getRequest()->getPostValue();
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($data) {
            $model = $this->departamentModelFactory->create();
            $resourceModel = $this->departamentResourceModelFactory->create();
            $id = $this->getRequest()->getParam('id');
            if ($id) {
                $resourceModel->load($model, $id);
            }
           $model->setData($data);
            $this->_eventManager->dispatch(
                'jobs_department_prepare_save',
                ['deparment' => $model, 'request' => $this->getRequest()]
            );

            try {
                $resourceModel->save($model);
                $this->messageManager->addSuccessMessage(__('Department saved'));
                $this->_getSession()->setFormData(false);
                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['id' => $model->getId(), '_current' => true]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (\Magento\Framework\Exception\LocalizedException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\RuntimeException $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the department'));
            }

            $this->_getSession()->setFormData($data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
