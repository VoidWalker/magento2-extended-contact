<?php

namespace Sohan\ExtendedContact\Block\Adminhtml\Edit;

use Sohan\ExtendedContact\Model\ContactRequestFactory;

class Reply extends \Magento\Backend\Block\Template
{
    public $contactRequestFactory;

    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        ContactRequestFactory $contactRequestFactory,
        array $data = []
    )
    {
        $this->contactRequestFactory = $contactRequestFactory;
        parent::__construct($context, $data);
    }

    public function getCustomerEmail()
    {
        $entityId = $this->getRequest()->getParam('entity_id');
        if (!$entityId) {
            throw new \Exception('Missing entity_id parameter');
        }
        try {
            $contactRequestModel = $this->contactRequestFactory->create();
            $contactRequestModel->load($entityId);
        } catch (\Exception $e) {
            throw new \NoSuchEntityException('No entity with such ID');
        }

        return $contactRequestModel->getEmail();
    }
}