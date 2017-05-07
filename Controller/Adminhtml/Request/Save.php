<?php

namespace Sohan\ExtendedContact\Controller\Adminhtml\Request;

use Magento\Backend\App\Action\Context;
use Sohan\ExtendedContact\Model\ContactRequest;
use Sohan\ExtendedContact\Model\ContactRequestFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Exception\LocalizedException;

class Save extends \Sohan\ExtendedContact\Controller\Adminhtml\Request
{
    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    protected $contactRequestFactory;

    /**
     * @param Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param DataPersistorInterface $dataPersistor
     */
    public function __construct(
        Context $context,
        \Magento\Framework\Registry $coreRegistry,
        DataPersistorInterface $dataPersistor,
        ContactRequestFactory $contactRequestFactory
    ) {
        $this->dataPersistor = $dataPersistor;
        $this->contactRequestFactory = $contactRequestFactory;
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Save action
     *
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();
        if ($data) {
            $id = $this->getRequest()->getParam('entity_id');

            if (empty($data['entity_id'])) {
                $data['entity_id'] = null;
            }

            /** @var ContactRequest $model */
            $model = $this->contactRequestFactory->create()->load($id);
            if (!$model->getId() && $id) {
                $this->messageManager->addError(__('This entity no longer exists.'));
                return $resultRedirect->setPath('*/*/');
            }

            $model->setData($data);

            try {
                $model->save();
                $this->messageManager->addSuccess(__('You saved the request.'));
                $this->dataPersistor->clear('contact_request');

                if ($this->getRequest()->getParam('back')) {
                    return $resultRedirect->setPath('*/*/edit', ['entity_id' => $model->getId()]);
                }
                return $resultRedirect->setPath('*/*/');
            } catch (LocalizedException $e) {
                $this->messageManager->addError($e->getMessage());
            } catch (\Exception $e) {
                $this->messageManager->addException($e, __('Something went wrong while saving the entity.'));
            }

            $this->dataPersistor->set('contact_request', $data);
            return $resultRedirect->setPath('*/*/edit', ['entity_id' => $this->getRequest()->getParam('entity_id')]);
        }
        return $resultRedirect->setPath('*/*/');
    }
}
