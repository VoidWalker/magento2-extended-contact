<?php

namespace Sohan\ExtendedContact\Block\Adminhtml\Edit;

use Magento\Backend\Block\Widget\Context;
use Sohan\ExtendedContact\Model\ContactRequestFactory;
use Magento\Framework\Exception\NoSuchEntityException;

/**
 * Class GenericButton
 */
class GenericButton
{
    /**
     * @var Context
     */
    protected $context;

    /**
     * @var ContactRequestFactory
     */
    protected $contactRequestFactory;

    /**
     * @param Context $context
     * @param ContactRequestFactory $contactRequestFactory
     */
    public function __construct(
        Context $context,
        ContactRequestFactory $contactRequestFactory
    )
    {
        $this->context = $context;
        $this->contactRequestFactory = $contactRequestFactory;
    }

    /**
     * Return CMS block ID
     *
     * @return int|null
     */
    public function getContactRequestId()
    {
        try {
            return $this->contactRequestFactory->create()
                ->load($this->context->getRequest()->getParam('entity_id'));
        } catch (NoSuchEntityException $e) {
        }
        return null;
    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array $params
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->context->getUrlBuilder()->getUrl($route, $params);
    }
}
