<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Api\Data;

/**
 * Interface ProductsUpdateScopeDataInterface
 */
interface ProductsUpdateScopeDataInterface
{
    /**#@+
     * Data key names.
     *
     * @const
     */
    public const string STORE_ID = 'store_id';
    public const string WEBSITE_ID = 'website_id';
    /** #@- */

    /**
     * Get store id.
     *
     * @return int|null
     */
    public function getStoreId(): ?int;

    /**
     * Set store id.
     *
     * @param int $storeId
     *
     * @return \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateScopeDataInterface
     */
    public function setStoreId(int $storeId): self;

    /**
     * Get website id.
     *
     * @return int|null
     */
    public function getWebsiteId(): ?int;

    /**
     * Set website id.
     *
     * @param int $websiteId
     *
     * @return \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateScopeDataInterface
     */
    public function setWebsiteId(int $websiteId): self;

    /**
     * Object data getter
     *
     * If $key is not defined will return all the data as an array.
     * Otherwise, it will return value of the element specified by $key.
     * It is possible to use keys like a/b/c for access nested array data
     *
     * If $index is specified it will assume that attribute data is an array
     * and retrieve corresponding member. If data is the string - it will be exploded
     * by new line character and converted to array.
     *
     * @param string $key
     * @param string|int $index
     * @return mixed
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    public function getData($key = '', $index = null);
}