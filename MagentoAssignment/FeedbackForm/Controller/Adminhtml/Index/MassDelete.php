<?php

namespace MagentoAssignment\FeedbackForm\Controller\Adminhtml\Index;

use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use MagentoAssignment\FeedbackForm\Model\ResourceModel\Feedback\CollectionFactory;
use MagentoAssignment\FeedbackForm\Model\FeedbackFactory;
use Magento\Backend\App\Action;

class MassDelete extends Action
{
    protected $_filter;
    protected $_collectionFactory;
    protected $_modelFactory;

    public function __construct(
        Context           $context,
        Filter            $filter,
        CollectionFactory $collectionFactory,
        FeedbackFactory   $modelFactory
    )
    {
        $this->_filter = $filter;
        $this->_collectionFactory = $collectionFactory;
        $this->_modelFactory = $modelFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $collection = $this->_filter->getCollection($this->_collectionFactory->create());
        $recordDeleted = $collection->getSize();
        $collection->walk('delete');
        $this->messageManager->addSuccessMessage(
            __('A total of %1 feedback(s) have been deleted.', $recordDeleted)
        );

        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)
            ->setPath('feedback/index/index');
    }

    /**
     * Check if admin user has permission to delete feedback.
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('MagentoAssignment_FeedbackForm::feedback_list');
    }
}
