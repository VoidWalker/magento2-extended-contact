<?php

namespace Sohan\ExtendedContact\Controller\Adminhtml\Request;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\Result\JsonFactory;
use Sohan\ExtendedContact\Model\ContactRequestFactory;
use Sohan\ExtendedContact\Model\ContactRequest;

class InlineEdit extends \Magento\Backend\App\Action
{
    /** @var JsonFactory */
    protected $jsonFactory;

    /** @var ContactRequestFactory */
    protected $contactRequestFactory;

    /**
     * @param Context $context
     * @param ContactRequestFactory $contactRequestFactory
     * @param JsonFactory $jsonFactory
     */
    public function __construct(
        Context $context,
        ContactRequestFactory $contactRequestFactory,
        JsonFactory $jsonFactory
    )
    {
        parent::__construct($context);
        $this->contactRequestFactory = $contactRequestFactory;
        $this->jsonFactory = $jsonFactory;
    }

    /**
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $resultJson */
        $resultJson = $this->jsonFactory->create();
        $error = false;
        $messages = [];

        if ($this->getRequest()->getParam('isAjax')) {
            $postItems = $this->getRequest()->getParam('items', []);
            if (!count($postItems)) {
                $messages[] = __('Please correct the data sent.');
                $error = true;
            } else {
                foreach (array_keys($postItems) as $requestId) {
                    /** @var ContactRequest $contactRequest */
                    $contactRequest = $this->contactRequestFactory->create()->load($requestId);
                    try {
                        $contactRequest->setData(array_merge($contactRequest->getData(), $postItems[$requestId]));
                        $contactRequest->save();
                    } catch (\Exception $e) {
                        $messages[] = $this->getErrorWithContactRequestId(
                            $contactRequest,
                            __($e->getMessage())
                        );
                        $error = true;
                    }
                }
            }
        }

        return $resultJson->setData([
            'messages' => $messages,
            'error' => $error
        ]);
    }

    /**
     * @param ContactRequest $contactRequest
     * @param $errorText
     * @return string
     */
    protected function getErrorWithContactRequestId(ContactRequest $contactRequest, $errorText)
    {
        return '[Contact Request ID: ' . $contactRequest->getId() . '] ' . $errorText;
    }
}
