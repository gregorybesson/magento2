<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

namespace Magento\UrlRewrite\Test\TestCase;

use Magento\Catalog\Test\Fixture\CatalogProductSimple;
use Magento\UrlRewrite\Test\Fixture\UrlRewrite;
use Magento\UrlRewrite\Test\Page\Adminhtml\UrlRewriteEdit;
use Magento\UrlRewrite\Test\Page\Adminhtml\UrlRewriteIndex;
use Mtf\TestCase\Injectable;

/**
 * Test Creation for Product URL Rewrites Entity
 *
 * Test Flow:
 * Preconditions:
 * 1. Create custom storeView
 * 2. Create simple product
 *
 * Steps:
 * 1. Open Backend
 * 2. Go to Marketing->Url Redirects
 * 3. Click "Add URL Rewrite" button
 * 4. Select "For Product" from  "Create URL Rewrite:" dropdown
 * 5. Select created early product
 * 6. Click "Skip Category Selection" button
 * 7. Fill data according to dataSet
 * 8. Perform all assertions
 *
 * @group URL_Rewrites_(MX)
 * @ZephyrId MAGETWO-25150
 */
class CreateProductUrlRewriteEntityTest extends Injectable
{
    /**
     * Url rewrite index page
     *
     * @var UrlRewriteIndex
     */
    protected $urlRewriteIndex;

    /**
     * Url rewrite edit page
     *
     * @var UrlRewriteEdit
     */
    protected $urlRewriteEdit;

    /**
     * Prepare pages
     *
     * @param UrlRewriteIndex $urlRewriteIndex
     * @param UrlRewriteEdit $urlRewriteEdit
     * @return void
     */
    public function __inject(UrlRewriteIndex $urlRewriteIndex, UrlRewriteEdit $urlRewriteEdit)
    {
        $this->urlRewriteIndex = $urlRewriteIndex;
        $this->urlRewriteEdit = $urlRewriteEdit;
    }

    /**
     * Create product URL Rewrite
     *
     * @param CatalogProductSimple $product
     * @param UrlRewrite $urlRewrite
     * @return void
     */
    public function test(CatalogProductSimple $product, UrlRewrite $urlRewrite)
    {
        //Precondition
        $product->persist();
        $filter = ['id' => $product->getId()];
        //Steps
        $this->urlRewriteIndex->open();
        $this->urlRewriteIndex->getPageActionsBlock()->addNew();
        $this->urlRewriteEdit->getFormBlock()->fill($urlRewrite);
        $this->urlRewriteEdit->getProductGridBlock()->searchAndOpen($filter);
        $this->urlRewriteEdit->getTreeBlock()->selectCategory($product->getCategoryIds());
        $this->urlRewriteEdit->getFormBlock()->fill($urlRewrite);
        $this->urlRewriteEdit->getPageMainActions()->save();
    }
}
