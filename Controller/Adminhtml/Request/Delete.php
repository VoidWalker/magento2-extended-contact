<?php

namespace Sohan\ExtendedContact\Controller\Adminhtml\Request;

use Sohan\ExtendedContact\Model\ContactRequestFactory;

class Delete extends \Sohan\ExtendedContact\Controller\Adminhtml\Request
{
    protected $contactRequestFactory;

    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        ContactRequestFactory $contactRequestFactory
    )
    {
        $this->$contactRequestFactory = $contactRequestFactory;
        parent::__construct($context, $coreRegistry, $contactRequestFactory);
    }
    /**
     * Delete action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('entity_id');
        if ($id) {
            try {
                // init model and delete
                $model = $this->$contactRequestFactory->create();
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('You deleted the request.'));
                // go to grid
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['entity_id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find an entity to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
