<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\Catalog\Model\Layer\Search;

use Magento\Catalog\Model\Config;
use Magento\Catalog\Model\Layer\CollectionFilterInterface;
use Magento\Catalog\Model\Product\Visibility;
use Magento\Framework\DB\Select;
use Magento\Store\Model\StoreManagerInterface;

class CollectionFilter implements CollectionFilterInterface
{
    /**
     * @var Config
     */
    protected $catalogConfig;

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var Visibility
     */
    protected $productVisibility;

    /**
     * @param Config $catalogConfig
     * @param StoreManagerInterface $storeManager
     * @param Visibility $productVisibility
     */
    public function __construct(
        Config $catalogConfig,
        StoreManagerInterface $storeManager,
        Visibility $productVisibility
    ) {
        $this->catalogConfig = $catalogConfig;
        $this->storeManager = $storeManager;
        $this->productVisibility = $productVisibility;
    }

    /**
     * Filter product collection
     *
     * @param \Magento\Catalog\Model\Resource\Product\Collection $collection
     * @param \Magento\Catalog\Model\Category $category
     * @return void
     */
    public function filter(
        $collection,
        \Magento\Catalog\Model\Category $category
    ) {
        $collection
            ->addAttributeToSelect($this->catalogConfig->getProductAttributes())
            ->setStore($this->storeManager->getStore())
            ->addMinimalPrice()
            ->addFinalPrice()
            ->addTaxPercents()
            ->addStoreFilter()
            ->addUrlRewrite()
            ->setVisibility($this->productVisibility->getVisibleInSearchIds())
            ->setOrder('relevance', Select::SQL_ASC);
    }
}
