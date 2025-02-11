<?php

namespace MagentoAssignment\FeedbackForm\Model\ResourceModel\Feedback;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use MagentoAssignment\FeedbackForm\Model\Feedback;
use MagentoAssignment\FeedbackForm\Model\ResourceModel\Feedback as FeedbackResource;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_idFieldName = 'id';

    /**
     * Define resource model.
     */
    protected function _construct()
    {
        $this->_init(Feedback::class, FeedbackResource::class);
    }
}
