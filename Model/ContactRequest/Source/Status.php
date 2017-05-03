<?php

namespace Sohan\ExtendedContact\Model\ContactRequest\Source;

use Magento\Framework\Data\OptionSourceInterface;

class Status implements OptionSourceInterface
{
    /**
     * @var \Sohan\ExtendedContact\Model\ContactRequest
     */
    protected $contactRequest;

    /**
     * Constructor
     *
     * @param \Sohan\ExtendedContact\Model\ContactRequest $contactRequest
     */
    public function __construct(\Sohan\ExtendedContact\Model\ContactRequest $contactRequest)
    {
        $this->contactRequest = $contactRequest;
    }

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = $this->contactRequest->getAvailableStatuses();
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
