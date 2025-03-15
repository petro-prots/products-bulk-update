<?php

declare(strict_types=1);

/**
 * @by Petro Prots
 */

namespace PetroProts\ProductsBulkUpdate\Test\Integration;

use PHPUnit\Framework\TestCase;
use Magento\TestFramework\Helper\Bootstrap;
use Magento\Framework\ObjectManagerInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\TestFramework\MessageQueue\PublisherConsumerController;
use Magento\TestFramework\MessageQueue\PreconditionFailedException;
use Magento\AsynchronousOperations\Model\ResourceModel\Bulk\Collection;
use Magento\TestFramework\MessageQueue\EnvironmentPreconditionException;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdateResultInterface;
use PetroProts\ProductsBulkUpdate\Api\Data\ProductsUpdatePayloadInterface;
use PetroProts\ProductsBulkUpdate\Api\UpdateProductAttributesActionInterface;

/**
 * Class ProductUpdateActionTest
 */
class ProductUpdateActionTest extends TestCase
{
    /**
     * @var ObjectManagerInterface
     */
    private ObjectManagerInterface $_objectManager;

    /**
     * @var PublisherConsumerController
     */
    private PublisherConsumerController $publisherConsumerController;

    /**
     * @var string[]
     */
    private array $consumers = ['product_action_attribute.update'];

    protected function setUp(): void
    {
        parent::setUp();

        $this->_objectManager = Bootstrap::getObjectManager();

        $this->publisherConsumerController = $this->_objectManager->create(
            PublisherConsumerController::class,
            [
                'consumers' => $this->consumers,
                'logFilePath' => TESTS_TEMP_DIR . "/MessageQueueTestLog.txt",
                'maxMessages' => null,
                'appInitParams' => Bootstrap::getInstance()->getAppInitParams()
            ]
        );

        try {
            $this->publisherConsumerController->startConsumers();
        } catch (EnvironmentPreconditionException $e) {
            $this->markTestSkipped($e->getMessage());
        } catch (PreconditionFailedException $e) {
            $this->fail(
                $e->getMessage()
            );
        }
    }

    protected function tearDown(): void
    {
        $this->publisherConsumerController->stopConsumers();
        parent::tearDown();
    }

    /**
     * Test Product attributes update successful action.
     *
     * @param array $productsData
     *
     * @return ProductsUpdateResultInterface
     *
     * @dataProvider productUpdateSuccessDataProvider
     *
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoDbIsolation disabled
     */
    public function testProductUpdateActionSuccessful(array $productsData): ProductsUpdateResultInterface
    {
        $updateAction = $this->_objectManager->create(UpdateProductAttributesActionInterface::class);

        try {
            $result = $updateAction->execute($productsData);
        } catch (LocalizedException $e) {
            $this->fail($e->getMessage());
        }

        $this->assertTrue($result->isSuccess());
        $this->assertEquals([1], $result->getProducts());
        $this->assertEmpty($result->getFailedProducts());
        $this->assertIsString($result->getQueueId());

        return $result;
    }

    /**
     * Test Product attributes update fails by product id.
     *
     * @param array $productsData
     *
     * @return void
     *
     * @dataProvider invalidProductIdDataProvider
     *
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoDbIsolation disabled
     */
    public function testProductUpdateInvalidProductId(array $productsData): void
    {
        $updateAction = $this->_objectManager->create(UpdateProductAttributesActionInterface::class);

        try {
            $result = $updateAction->execute($productsData);
        } catch (LocalizedException $e) {
            $this->fail($e->getMessage());
        }

        $this->assertEmpty($result->getProducts());
        $this->assertEquals([1], $result->getFailedProducts());
    }

    /**
     * Test Product attributes update fails by wrong attribute name.
     *
     * @param array $productsData
     *
     * @return void
     *
     * @dataProvider invalidAttributeDataProvider
     *
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoDbIsolation disabled
     */
    public function testProductUpdateInvalidAttribute(array $productsData): void
    {
        $updateAction = $this->_objectManager->create(UpdateProductAttributesActionInterface::class);

        try {
            $result = $updateAction->execute($productsData);
        } catch (LocalizedException $e) {
            $this->fail($e->getMessage());
        }

        $this->assertEmpty($result->getProducts());
        $this->assertEquals([1], $result->getFailedProducts());
    }

    /**
     * Test the created products update produces the bulk message.
     *
     * @param ProductsUpdateResultInterface $productsUpdateResult
     *
     * @depends testProductUpdateActionSuccessful
     *
     * @return void
     */
    public function testProductUpdateCreatesQueue(ProductsUpdateResultInterface $productsUpdateResult)
    {
        $collection = $this->_objectManager->create(Collection::class);
        $collection->addFieldToFilter('uuid', $productsUpdateResult->getQueueId());

        $this->assertEquals(1, $collection->getSize());
    }

    /**
     * Get successful data payload.
     *
     * @return array
     */
    public function productUpdateSuccessDataProvider(): array
    {
        $data = [];

        $data[] = [
            $this->_objectManager->create(ProductsUpdatePayloadInterface::class, [
                'data' => [
                    "id" => 1,
                    "attribute" => "name",
                    "value" => "New name"
                ]
            ])
        ];

        return $data;
    }

    /**
     * Get successful data payload.
     *
     * @return array
     */
    public function invalidProductIdDataProvider(): array
    {
        $data = [];

        $data[] = [
            $this->_objectManager->create(ProductsUpdatePayloadInterface::class, [
                'data' => [
                    "id" => 2,
                    "attribute" => "name",
                    "value" => "New name"
                ]
            ])
        ];

        return $data;
    }

    /**
     * Get successful data payload.
     *
     * @return array
     */
    public function invalidAttributeDataProvider(): array
    {
        $data = [];

        $data[] = [
            $this->_objectManager->create(ProductsUpdatePayloadInterface::class, [
                'data' => [
                    "id" => 1,
                    "attribute" => "unavailable_wrong_attr",
                    "value" => "Changed Value"
                ]
            ])
        ];

        return $data;
    }
}