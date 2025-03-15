<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Model\Validator;

use Magento\Catalog\Model\Product;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use PetroProts\ProductsBulkUpdate\Api\PayloadValidatorInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface;

/**
 * Class AttributeValidator
 */
class AttributeValidator implements PayloadValidatorInterface
{
    /**
     * AttributeValidator constructor.
     *
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        protected AttributeRepositoryInterface $attributeRepository,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function validate(ProductsUpdatePayloadInterface $payload): bool
    {
        try {
            $this->attributeRepository->get(Product::ENTITY, $payload->getAttribute());
        } catch (NoSuchEntityException) {
            return false;
        }

        return true;
    }
}