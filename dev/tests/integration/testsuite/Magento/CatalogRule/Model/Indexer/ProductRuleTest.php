<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\CatalogRule\Model\Indexer;

use Magento\TestFramework\Helper\Bootstrap;

/**
 * @magentoDbIsolation enabled
 * @magentoAppIsolation enabled
 */
class ProductRuleTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Magento\CatalogRule\Model\Resource\Rule
     */
    protected $resourceRule;

    /**
     * @var \Magento\Catalog\Model\Product
     */
    protected $product;

    protected function setUp()
    {
        $this->resourceRule = Bootstrap::getObjectManager()->get('Magento\CatalogRule\Model\Resource\Rule');
        $this->product = Bootstrap::getObjectManager()->get('Magento\Catalog\Model\Product');

        Bootstrap::getObjectManager()->get('Magento\CatalogRule\Model\Indexer\Product\ProductRuleProcessor')
            ->getIndexer()->isScheduled(false);
    }

    /**
     * @magentoDataFixture Magento/CatalogRule/_files/attribute.php
     * @magentoDataFixture Magento/CatalogRule/_files/rule_by_attribute.php
     * @magentoDataFixture Magento/Catalog/_files/product_simple.php
     * @magentoAppArea adminhtml
     */
    public function testReindexAfterSuitableProductSaving()
    {
        $this->product->load(1)->setData('test_attribute', 'test_attribute_value')->save();

        $this->assertEquals(9.8, $this->resourceRule->getRulePrice(true, 1, 1, 1));
    }
}
