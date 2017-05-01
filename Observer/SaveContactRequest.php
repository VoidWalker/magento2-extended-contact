<?php

namespace Sohan\ExtendedContact\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;
use Sohan\ExtendedContact\Model\ContactRequestFactory;

class SaveContactRequest implements ObserverInterface
{

    public $contactRequestFactory;

    public function __construct(ContactRequestFactory $contactRequestFactory)
    {
        $this->contactRequestFactory = $contactRequestFactory;
    }

    public function execute(EventObserver $observer)
    {
        $postData = $observer->getRequest()->getPostValue();

        try {
            $contactRequest = $this->contactRequestFactory->create();

            $contactRequest->setName($postData['name']);
            $contactRequest->setEmail($postData['email']);
            $contactRequest->setTelephone($postData['telephone']);
            $contactRequest->setComment($postData['comment']);

            $contactRequest->save();
        } catch (\Exception $e) {
            throw new \Exception('Oops!');
        }
    }
} 