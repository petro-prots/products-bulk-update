<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Model\Data;

use Magento\Framework\DataObject;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateResultInterface;

class ProductsUpdateResult extends DataObject implements ProductsUpdateResultInterface
{
    /**
     * @inheritDoc
     */
    public function isSuccess(): bool
    {
        return (bool)$this->getData(static::IS_SUCCESS);
    }

    /**
     * @inheritDoc
     */
    public function setIsSuccess(bool $isSuccess): self
    {
        return $this->setData(static::IS_SUCCESS, $isSuccess);
    }

    /**
     * @inheritDoc
     */
    public function getProducts(): array
    {
        return $this->getData(static::PRODUCTS) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function setProducts(array $products): self
    {
        return $this->setData(static::PRODUCTS, $products);
    }

    /**
     * @inheritDoc
     */
    public function getFailedProducts(): array
    {
        return $this->getData(static::FAILED_PRODUCTS) ?? [];
    }

    /**
     * @inheritDoc
     */
    public function setFailedProducts(array $failedProducts): self
    {
        return $this->setData(static::FAILED_PRODUCTS, $failedProducts);
    }

    /**
     * @inheritDoc
     */
    public function getQueueId(): string
    {
        return $this->getData(static::QUEUE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setQueueId(string $queueId): self
    {
        return $this->setData(static::QUEUE_ID, $queueId);
    }
}
