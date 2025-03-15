<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Model\Data;

use Magento\Framework\DataObject;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateInputInterface;

class ProductsUpdateInput extends DataObject implements ProductsUpdateInputInterface
{
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
    public function setProducts(?array $products): self
    {
        $this->setData(static::PRODUCTS, $products);
        return $this;
    }
}
