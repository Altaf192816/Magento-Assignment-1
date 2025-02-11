<?php

namespace MagentoAssignment\FeedbackForm\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use MagentoAssignment\FeedbackForm\Model\FeedbackFactory;

class Delete extends Action
{
    public FeedbackFactory $collectionFactory;

    public function __construct(
        Context         $context,
        FeedbackFactory $collectionFactory,
    )
    {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        try {
            if (isset($id)) {
                $blogModel = $this->collectionFactory->create();
                $blogModel->load($id);
                $blogModel->delete();
                $this->messageManager->addSuccessMessage(__('You deleted the blog.'));
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
        }
        return $resultRedirect->setPath('feedback/index/index');
    }

    public function _isAllowed()
    {
        return $this->_authorization->isAllowed('MagentoAssignment_FeedbackForm::feedback_list');
    }
}
