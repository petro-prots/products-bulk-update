<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Api;

use Magento\Framework\Exception\InputException;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateInputInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateResultInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateScopeDataInterface;

/**
 * Interface UpdateProductAttributesActionInterface
 *
 * @api
 */
interface UpdateProductAttributesActionInterface
{
    /**
     * Update products' attributes data by given input.
     *
     * @param \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface[] $products
     * @param \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateScopeDataInterface|null $scopeData
     *
     * @return \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateResultInterface
     *
     * @throws \Magento\Framework\Exception\InputException In case if issues with the input data.
     * @throws \Magento\Framework\Exception\LocalizedException In case if issues with the data processing.
     */
    public function execute(array $products, ?ProductsUpdateScopeDataInterface $scopeData = null): ProductsUpdateResultInterface;
}
