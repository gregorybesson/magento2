<?php
/**
 * CatalogRule Rule Job model
 *
 * Uses for encapsulate some logic of rule model and for having ability change behavior (for example, in controller)
 *
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */

/**
 * Catalog Rule job model
 *
 * @method \Magento\CatalogRule\Model\Rule\Job setSuccess(string $errorMessage)
 * @method \Magento\CatalogRule\Model\Rule\Job setError(string $errorMessage)
 * @method string getSuccess()
 * @method string getError()
 * @method bool hasSuccess()
 * @method bool hasError()
 *
 * @author    Magento Core Team <core@magentocommerce.com>
 */
namespace Magento\CatalogRule\Model\Rule;

use Magento\CatalogRule\Model\Indexer\Rule\RuleProductProcessor;

class Job extends \Magento\Framework\Object
{
    /**
     * @var RuleProductProcessor
     */
    protected $ruleProcessor;

    /**
     * Basic object initialization
     *
     * @param RuleProductProcessor $ruleProcessor
     */
    public function __construct(RuleProductProcessor $ruleProcessor)
    {
        $this->ruleProcessor = $ruleProcessor;
    }

    /**
     * Dispatch event "catalogrule_apply_all" and set success or error message depends on result
     *
     * @return \Magento\CatalogRule\Model\Rule\Job
     */
    public function applyAll()
    {
        try {
            $this->ruleProcessor->markIndexerAsInvalid();
            $this->setSuccess(__('Updated rules applied.'));
        } catch (\Magento\Framework\Model\Exception $e) {
            $this->setError($e->getMessage());
        }
        return $this;
    }
}
