<?php

namespace Sohan\ExtendedContact\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class ContactRequest extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'sohan_extendedcontact_contact_request';

    protected function _construct()
    {
        $this->_init('Sohan\ExtendedContact\Model\ResourceModel\ContactRequest');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }
}
