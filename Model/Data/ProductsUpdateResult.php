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
        $this->setData(static::IS_SUCCESS, $isSuccess);
        return $this;
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
        $this->setData(static::PRODUCTS, $products);
        return $this;
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
        $this->setData(static::FAILED_PRODUCTS, $failedProducts);
        return $this;
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
        $this->setData(static::QUEUE_ID, $queueId);
        return $this;
    }
}
