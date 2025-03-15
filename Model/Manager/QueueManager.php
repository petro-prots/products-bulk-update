<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Model\Manager;

use Magento\Framework\Serialize\SerializerInterface;
use PetroProts\ProductsBulkUpdate\Api\QueueManagerInterface;
use Magento\AsynchronousOperations\Api\Data\OperationInterface;
use Magento\AsynchronousOperations\Api\Data\OperationInterfaceFactory;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateScopeDataInterface;

/**
 * Class QueueManager
 */
class QueueManager implements QueueManagerInterface
{
    /**
     * QueueManager constructor.
     *
     * @param OperationInterfaceFactory $operationFactory
     * @param SerializerInterface $serializer
     */
    public function __construct(
        protected OperationInterfaceFactory $operationFactory,
        protected SerializerInterface $serializer,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function makeUpdate(
        string $meta,
        ProductsUpdatePayloadInterface $payload,
        ProductsUpdateScopeDataInterface $scopeData,
        string $bulkUuid,
    ): OperationInterface {
        $dataToEncode = [
            'meta_information' => $meta,
            'product_ids' => [$payload->getId()],
            ...$scopeData->getData(),
            'attributes' => [
                $payload->getAttribute() => $payload->getValue()
            ]
        ];

        $data = [
            'data' => [
                'bulk_uuid' => $bulkUuid,
                'topic_name' => static::QUEUE_NAME,
                'serialized_data' => $this->serializer->serialize($dataToEncode),
                'status' => \Magento\Framework\Bulk\OperationInterface::STATUS_TYPE_OPEN,
            ]
        ];

        return $this->operationFactory->create($data);
    }


}