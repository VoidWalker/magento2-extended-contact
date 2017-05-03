<?php

namespace Sohan\ExtendedContact\Model\ContactRequest;

use Sohan\ExtendedContact\Model\ResourceModel\ContactRequest\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;

/**
 * Class DataProvider
 */
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var \Sohan\ExtendedContact\Model\ResourceModel\ContactRequest\Collection
     */
    protected $collection;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * Constructor
     *
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactRequestCollectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactRequestCollectionFactory,
        DataPersistorInterface $dataPersistor,
        array $meta = [],
        array $data = []
    )
    {
        $this->collection = $contactRequestCollectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        /** @var \Sohan\ExtendedContact\Model\ContactRequest $contactRequest */
        foreach ($items as $contactRequest) {
            $this->loadedData[$contactRequest->getId()] = $contactRequest->getData();
        }

        $data = $this->dataPersistor->get('contact_request');
        if (!empty($data)) {
            $contactRequest = $this->collection->getNewEmptyItem();
            $contactRequest->setData($data);
            $this->loadedData[$contactRequest->getId()] = $contactRequest->getData();
            $this->dataPersistor->clear('contact_request');
        }

        return $this->loadedData;
    }
}
