<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Model\Data;

use Magento\Framework\DataObject;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateScopeDataInterface;

/**
 * Class ProductUpdateScopeData
 */
class ProductsUpdateScopeData extends DataObject implements ProductsUpdateScopeDataInterface
{
    /**
     * @inheritDoc
     */
    public function getStoreId(): ?int
    {
        return !$this->getData(static::STORE_ID) ? null : (int)$this->getData(static::STORE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setStoreId(int $storeId): ProductsUpdateScopeDataInterface
    {
        return $this->setData(static::STORE_ID, $storeId);
    }

    /**
     * @inheritDoc
     */
    public function getWebsiteId(): ?int
    {
        return !$this->getData(static::WEBSITE_ID) ? null : (int)$this->getData(static::WEBSITE_ID);
    }

    /**
     * @inheritDoc
     */
    public function setWebsiteId(int $websiteId): ProductsUpdateScopeDataInterface
    {
        return $this->setData(static::WEBSITE_ID, $websiteId);
    }
}