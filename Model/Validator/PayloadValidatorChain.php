<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Model\Validator;

use Magento\Setup\Console\InputValidationException;
use PetroProts\ProductsBulkUpdate\Api\PayloadValidatorInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface;

/**
 * Class PayloadValidatorChain
 */
class PayloadValidatorChain implements PayloadValidatorInterface
{
    /**
     * Product Validators list.
     *
     * @var PayloadValidatorInterface[]
     */
    protected array $productValidators = [];

    /**
     * PayloadValidatorChain constructor.
     *
     * @param PayloadValidatorInterface[] $productValidators
     */
    public function __construct(
        array $productValidators = []
    ) {
        foreach ($productValidators as $productValidator) {
            if (!$productValidator instanceof PayloadValidatorInterface) {
                throw new InputValidationException(
                    (string)__('Product validator must implement PayloadValidatorInterface')
                );
            }

            $this->productValidators[] = $productValidator;
        }
    }

    /**
     * @inheritDoc
     */
    public function validate(ProductsUpdatePayloadInterface $payload): bool
    {
        foreach ($this->productValidators as $productValidator) {
            if (!$productValidator->validate($payload)) {
                return false;
            }
        }

        return true;
    }
}