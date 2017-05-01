<?php

namespace Sohan\ExtendedContact\Model\ResourceModel\ContactRequest;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Sohan\ExtendedContact\Model\ContactRequest','Sohan\ExtendedContact\Model\ResourceModel\ContactRequest');
    }
} 