<?php

namespace Sohan\ExtendedContact\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;


class ContactRequest extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('sohan_extendedcontact_contact_request', 'entity_id');
    }
} 