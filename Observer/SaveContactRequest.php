<?php

namespace Sohan\ExtendedContact\Observer;

use Magento\Framework\Event\Observer as EventObserver;
use Magento\Framework\Event\ObserverInterface;

class SaveContactRequest implements ObserverInterface
{

    public function execute(EventObserver $observer)
    {
        $params = $observer->getRequest()->getParams();
    }
} 