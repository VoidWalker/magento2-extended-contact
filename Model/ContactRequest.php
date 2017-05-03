<?php

namespace Sohan\ExtendedContact\Model;

use Magento\Framework\Model\AbstractModel;
use Magento\Framework\DataObject\IdentityInterface;

class ContactRequest extends AbstractModel implements IdentityInterface
{
    const CACHE_TAG = 'sohan_extendedcontact_contact_request';

    const STATUS_NOT_ANSWERED = 0;
    const STATUS_ANSWERED = 1;

    protected function _construct()
    {
        $this->_init('Sohan\ExtendedContact\Model\ResourceModel\ContactRequest');
    }

    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    public function getAvailableStatuses()
    {
        return [self::STATUS_NOT_ANSWERED => __('Not Answered'), self::STATUS_ANSWERED => __('Answered')];
    }
}
