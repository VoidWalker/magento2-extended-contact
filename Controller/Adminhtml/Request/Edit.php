<?php

namespace Sohan\ExtendedContact\Controller\Adminhtml\Request;

use Sohan\ExtendedContact\Model\ContactRequestFactory;

class Edit extends \Sohan\ExtendedContact\Controller\Adminhtml\Request
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;

    protected $contactRequestFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     * @param ContactRequestFactory $contactRequestFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        ContactRequestFactory $contactRequestFactory
    )
    {
        $this->resultPageFactory = $resultPageFactory;
        $this->contactRequestFactory = $contactRequestFactory;
        parent::__construct($context, $coreRegistry, $contactRequestFactory);
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {
        $id = $this->getRequest()->getParam('entity_id');
        $contactRequest = $this->contactRequestFactory->create();

        if ($id) {
            $contactRequest->load($id);
            if (!$contactRequest->getId()) {
                $this->messageManager->addError(__('This item no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }

        $this->_coreRegistry->register('sohan_extendedcontact_request', $contactRequest);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Sohan_ExtendedContact::contact_request');
        $this->initPage($resultPage)->addBreadcrumb(
            __('Edit Contact Request'),
            __('Edit Contact Request')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Contact Requests'));

        return $resultPage;
    }
}
