<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Action;

use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Exception\InputException;
use Magento\Framework\DataObject\IdentityService;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Bulk\BulkManagementInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use PetroProts\ProductsBulkUpdate\Api\QueueManagerInterface;
use PetroProts\ProductsBulkUpdate\Api\PayloadValidatorInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateResultInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateScopeDataInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateScopeDataInterfaceFactory;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateResultInterfaceFactory;
use PetroProts\ProductsBulkUpdate\Api\UpdateProductAttributesActionInterface;

/**
 * Class UpdateProductAttributes
 */
class UpdateProductAttributes implements UpdateProductAttributesActionInterface
{
    /**
     * UpdateProductAttributes constructor.
     *
     * @param ProductsUpdateResultInterfaceFactory $resultFactory
     * @param IdentityService $identityService
     * @param StoreManagerInterface $storeManager
     * @param BulkManagementInterface $bulkManagement
     * @param QueueManagerInterface $queueManager
     * @param ProductsUpdateScopeDataInterfaceFactory $scopeDataFactory
     * @param PayloadValidatorInterface $payloadValidator
     */
    public function __construct(
        protected ProductsUpdateResultInterfaceFactory $resultFactory,
        protected IdentityService $identityService,
        protected StoreManagerInterface $storeManager,
        protected BulkManagementInterface $bulkManagement,
        protected QueueManagerInterface $queueManager,
        protected ProductsUpdateScopeDataInterfaceFactory $scopeDataFactory,
        protected PayloadValidatorInterface $payloadValidator,
    ) {
    }

    /**
     * @inheritDoc
     */
    public function execute(
        array $products,
        ?ProductsUpdateScopeDataInterface $scopeData = null
    ): ProductsUpdateResultInterface {
        $bulkUuid = $this->identityService->generateId();
        $bulkDescription = __('Update requested products\' attributes');

        try {
            $scopeData = $this->hydrateScopeData($scopeData);
        } catch (NoSuchEntityException) {
            throw new InputException(__("Invalid store id given"));
        }

        $operations = [];
        $passedProducts = [];
        $failedProducts = [];
        foreach ($products as $productData) {
            if (!$this->payloadValidator->validate($productData)) {
                $failedProducts[] = $productData->getId();
                continue;
            }

            $operations[] = $this->queueManager->makeUpdate(
                (string)__(
                    "Update product %1 attribute %2 value",
                    $productData->getId(),
                    $productData->getAttribute()
                ),
                $productData,
                $scopeData,
                $bulkUuid
            );

            $passedProducts[] = $productData->getId();
        }

        if (!$this->bulkManagement->scheduleBulk(
            $bulkUuid,
            $operations,
            $bulkDescription
        )) {
            throw new LocalizedException(__('Failed to create scheduled operation.'));
        }

        return $this->resultFactory->create()->setIsSuccess(true)
            ->setProducts($passedProducts)
            ->setFailedProducts($failedProducts)
            ->setQueueId($bulkUuid);
    }

    /**
     * Hydrate input with the scope data.
     *
     * @param ProductsUpdateScopeDataInterface|null $scopeData
     *
     * @return ProductsUpdateScopeDataInterface
     * @throws NoSuchEntityException
     */
    private function hydrateScopeData(?ProductsUpdateScopeDataInterface $scopeData): ProductsUpdateScopeDataInterface
    {
        if (!$scopeData) {
            $scopeData = $this->scopeDataFactory->create();
        }
        if ($scopeData->getStoreId() === null) {
            $storeId = $this->storeManager->getStore()->getId();
            $scopeData->setStoreId((int)$storeId);
        }

        if ($scopeData->getWebsiteId() === null) {
            $websiteId = $this->storeManager->getStore(
                $scopeData->getStoreId()
            )->getWebsiteId();
            $scopeData->setWebsiteId((int)$websiteId);
        }

        return $scopeData;
    }
}