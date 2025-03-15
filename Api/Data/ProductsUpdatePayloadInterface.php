<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Api\Data;

use Magento\Framework\Exception\InputException;

/**
 * Interface ProductUpdateAttributeDataInterface
 */
interface ProductsUpdatePayloadInterface
{
    /**#@+
     * Data key names.
     *
     * @const
     */
    public const string ID = "id";
    public const string ATTRIBUTE = "attribute";
    public const string VALUE = "value";
    /** #@- */

    /**
     * Get product id.
     *
     * @return int
     *
     * @throws InputException If trying to access empty id.
     */
    public function getId(): int;

    /**
     * Set Product id.
     *
     * @param int $id
     *
     * @return \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface
     */
    public function setId(int $id): self;

    /**
     * Get target attribute code.
     *
     * @return string
     */
    public function getAttribute(): string;

    /**
     * Set target attribute code.
     *
     * @param string $attribute
     *
     * @return \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface
     */
    public function setAttribute(string $attribute): self;

    /**
     * Get needed value.
     *
     * @return string
     *
     * @note <b>string</b> type is used as the general format.
     */
    public function getValue(): string;

    /**
     * Set needed value.
     *
     * @param string $value
     *
     * @return \PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface
     *
     * @note <b>string</b> type is used as the general format.
     */
    public function setValue(string $value): self;
}