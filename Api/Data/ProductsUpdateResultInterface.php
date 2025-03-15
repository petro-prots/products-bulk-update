<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Api\Data;

/**
 * Interface ProductsUpdateResultInterface
 */
interface ProductsUpdateResultInterface
{
    /**#@+
     * Data key names.
     *
     * @const
     */
    public const string IS_SUCCESS = "is_success";
    public const string PRODUCTS = "products";
    public const string FAILED_PRODUCTS = "failed_products";
    public const string QUEUE_ID = "queue_id";
    /** #@- */

    /**
     * Get whether request was successful.
     *
     * @return bool
     */
    public function isSuccess(): bool;

    /**
     * Set is_success flag.
     *
     * @param bool $isSuccess
     *
     * @return \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateResultInterface
     */
    public function setIsSuccess(bool $isSuccess): self;

    /**
     * Get list of products added to queue.
     *
     * @return int[]
     */
    public function getProducts(): array;

    /**
     * Set list of products added to queue.
     *
     * @param array $products
     *
     * @return \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateResultInterface
     */
    public function setProducts(array $products): self;

    /**
     * Get list of failed products.
     *
     * @return int[]
     */
    public function getFailedProducts(): array;

    /**
     * Set list of failed products.
     *
     * @param array $products
     *
     * @return \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateResultInterface
     */
    public function setFailedProducts(array $failedProducts): self;

    /**
     * Get associated queue id.
     *
     * @return string
     */
    public function getQueueId(): string;

    /**
     * Set associated queue id.
     *
     * @param string $queueId
     *
     * @return \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateResultInterface
     */
    public function setQueueId(string $queueId): self;
}