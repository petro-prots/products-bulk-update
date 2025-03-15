<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Model\Validator;

use Magento\Catalog\Model\Product;
use Magento\Framework\Exception\InputException;
use Magento\Catalog\Api\Data\ProductInterfaceFactory;
use Magento\Catalog\Model\ResourceModel\Product as ProductResourceModel;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use PetroProts\ProductsBulkUpdate\Api\PayloadValidatorInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface;

/**
 * Class AttributeValidator
 */
class ProductValidator implements PayloadValidatorInterface
{
    /**
     * AttributeValidator constructor.
     *
     * @param ProductResourceModel $productResource
     * @param ProductInterfaceFactory $productFactory
     */
    public function __construct(
        protected ProductResourceModel $productResource,
        protected ProductInterfaceFactory $productFactory,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function validate(ProductsUpdatePayloadInterface $payload): bool
    {
        /** @var Product $product */
        $product = $this->productFactory->create();

        try {
            $this->productResource->load($product, $payload->getId());

            return $product->getId() == $payload->getId() && !$product->isObjectNew();
        } catch (InputException $e) {
            return false;
        }
    }
}