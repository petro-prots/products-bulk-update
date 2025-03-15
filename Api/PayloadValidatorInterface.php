<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Api;

use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface;

/**
 * Interface PayloadValidatorInterface
 *
 * @api
 */
interface PayloadValidatorInterface
{
    /**
     * Validate payload data.
     *
     * @param ProductsUpdatePayloadInterface $payload
     *
     * @return bool
     */
    public function validate(ProductsUpdatePayloadInterface $payload): bool;
}