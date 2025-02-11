<?php

namespace MagentoAssignment\FeedbackForm\Controller\Adminhtml\Index;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Escaper;
use Magento\Framework\View\Result\PageFactory;
use MagentoAssignment\FeedbackForm\Helper\Validation;
use MagentoAssignment\FeedbackForm\Model\FeedbackFactory;

class Save extends Action
{
    protected $resultPageFactory = false;
    protected $collectionFactory;
    protected $escaper;
    protected Validation $validationHelper;

    public function __construct(
        Context         $context,
        PageFactory     $resultPageFactory,
        FeedbackFactory $collectionFactory,
        Escaper         $escaper,
        Validation      $validationHelper,

    )
    {
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
        $this->escaper = $escaper;
        $this->validationHelper = $validationHelper;
    }

    public function execute()
    {
        $data = $this->getRequest()->getPostValue();

        $name = $this->escaper->escapeHtml($data['name']);
        $email = $this->escaper->escapeHtml($data['email']);
        $telephone = $this->escaper->escapeHtml($data['telephone']);
        $comment = $this->escaper->escapeHtml($data['comment']);

        $this->validationHelper->validateEmail($email);
        $this->validationHelper->validateTelephone($telephone);
        $this->validationHelper->validateName($name);

        $data = [
            'name' => $name,
            'email' => $email,
            'telephone' => $telephone,
            'comment' => $comment,
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $resultRedirect = $this->resultRedirectFactory->create();
        $id = $this->getRequest()->getParam('id');
        try {
            if (isset($id)) {
                $model = $this->collectionFactory->create()->load($id);
                $model->addData($data);
                $model->save();
                $this->messageManager->addSuccessMessage(__('You saved the feedback.'));
            }

        } catch (\Exception $e) {
            $this->messageManager->addExceptionMessage($e, __('Something went wrong while saving the feedback.'));
        }
        return $resultRedirect->setPath('feedback/index/index');
    }
}
