<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Api;

use Magento\AsynchronousOperations\Api\Data\OperationInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateScopeDataInterface;

/**
 * Interface QueueManagerInterface
 */
interface QueueManagerInterface
{
    /**#@+
     * Queue metadata.
     *
     * @const
     */
    public const string QUEUE_NAME = 'product_action_attribute.update';
    /** #@- */

    /**
     * Make asynchronous operation.
     *
     * @param string $meta
     * @param ProductsUpdatePayloadInterface $payload
     * @param ProductsUpdateScopeDataInterface $scopeData
     * @param string $bulkUuid
     *
     * @return OperationInterface
     */
    public function makeUpdate(
        string $meta,
        ProductsUpdatePayloadInterface $payload,
        ProductsUpdateScopeDataInterface $scopeData,
        string $bulkUuid
    ): OperationInterface;
}