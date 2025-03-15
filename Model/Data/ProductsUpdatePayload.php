<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Model\Data;

use Magento\Framework\DataObject;
use Magento\Framework\Exception\InputException;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface;

class ProductsUpdatePayload extends DataObject implements ProductsUpdatePayloadInterface
{
    /**
     * @inheritDoc
     */
    public function getId(): int
    {
        if (!$this->getData(static::ID)) {
            throw new InputException(__("Trying to access empty product id"));
        }

        return (int)$this->getData(static::ID);
    }

    /**
     * @inheritDoc
     */
    public function setId(int $id): self
    {
        return $this->setData(static::ID, $id);
    }

    /**
     * @inheritDoc
     */
    public function getAttribute(): string
    {
        return $this->getData(static::ATTRIBUTE);
    }

    /**
     * @inheritDoc
     */
    public function setAttribute(?string $attribute): self
    {
        return $this->setData(static::ATTRIBUTE, $attribute);
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string
    {
        return $this->getData(static::VALUE);
    }

    /**
     * @inheritDoc
     */
    public function setValue(string $value): self
    {
        return $this->setData(static::VALUE, $value);
    }
}
