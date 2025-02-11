<?php

namespace MagentoAssignment\FeedbackForm\Controller\Index;

use Magento\Framework\App\Action\Context;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Escaper;
use Magento\Framework\Mail\Template\TransportBuilder;
use Magento\Framework\Message\ManagerInterface;
use Magento\Framework\Translate\Inline\StateInterface;
use Magento\Store\Model\StoreManagerInterface;
use MagentoAssignment\FeedbackForm\Helper\Validation;
use MagentoAssignment\FeedbackForm\Model\FeedbackFactory;
use Psr\Log\LoggerInterface;

class Submit extends \Magento\Framework\App\Action\Action
{
    const XML_PATH_EMAIL_RECIPIENT_NAME = 'trans_email/ident_support/name';
    const XML_PATH_EMAIL_RECIPIENT_EMAIL = 'trans_email/ident_support/email';
    protected $_inlineTranslation;
    protected $_transportBuilder;
    protected $_scopeConfig;
    protected $_logLoggerInterface;
    protected $storeManager;
    protected $feedbackFactory;
    protected $messageManager;
    protected $escaper;
    protected Validation $validationHelper;

    public function __construct(
        Context               $context,
        ManagerInterface      $messageManager,
        FeedbackFactory       $feedbackFactory,
        Validation            $validationHelper,

        StateInterface        $inlineTranslation,
        TransportBuilder      $transportBuilder,
        ScopeConfigInterface  $scopeConfig,
        LoggerInterface       $loggerInterface,
        StoreManagerInterface $storeManager,
        Escaper               $escaper
    )
    {
        parent::__construct($context);
        $this->messageManager = $messageManager;
        $this->feedbackFactory = $feedbackFactory;

        $this->_inlineTranslation = $inlineTranslation;
        $this->_transportBuilder = $transportBuilder;
        $this->_scopeConfig = $scopeConfig;
        $this->_logLoggerInterface = $loggerInterface;
        $this->storeManager = $storeManager;
        $this->escaper = $escaper;
        $this->validationHelper = $validationHelper;
    }

    public function execute()
    {
        $postData = $this->getRequest()->getPostValue();

        if ($postData) {
            try {
                // Retrieve form data and Sanitize inputs to prevent XSS
                $name = $this->escaper->escapeHtml($postData['name']);
                $email = $this->escaper->escapeHtml($postData['email']);
                $telephone = $this->escaper->escapeHtml($postData['telephone']);
                $comment = $this->escaper->escapeHtml($postData['message']);

                // Input validation
                $this->validationHelper->validateEmail($email);
                $this->validationHelper->validateTelephone($telephone);
                $this->validationHelper->validateName($name);

                // Prepare data to save in the database
                $data = [
                    'name' => $name,
                    'email' => $email,
                    'telephone' => $telephone,
                    'comment' => $comment,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                // Create and save the model
                $feedbackModel = $this->feedbackFactory->create();
                $feedbackModel->setData($data);
                $feedbackModel->save();

                // Send Mail to Admin
                $this->_inlineTranslation->suspend();
                $sender = [
                    'name' => $name,
                    'email' => $email
                ];
                $sentToEmail = $this->_scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT_EMAIL, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
                $sentToName = $this->_scopeConfig->getValue(self::XML_PATH_EMAIL_RECIPIENT_NAME, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
                $transport = $this->_transportBuilder
                    ->setTemplateIdentifier('customemail_email_template')
                    ->setTemplateOptions(
                        [
                            'area' => 'frontend',
                            'store' => $this->storeManager->getStore()->getId()
                        ]
                    )
                    ->setTemplateVars([
                        'name' => $name,
                        'email' => $email,
                        'telephone' => $telephone,
                        'comment' => $comment,
                    ])
                    ->setFromByScope($sender)
                    ->addTo($sentToEmail, $sentToName)
                    ->getTransport();
                $transport->sendMessage();
                $this->_inlineTranslation->resume();

                // Add success message
                $this->messageManager->addSuccessMessage(__('Thank you for your feedback!'));

                // Redirect to feedback form or success page
                return $this->resultRedirectFactory->create()->setPath('feedback/index');
            } catch (\Exception $e) {
                // Add error message
                $this->_logLoggerInterface->debug($e->getMessage());
                $this->messageManager->addErrorMessage(__('Failed to send feedback!'));
            }
        }

        return $this->resultRedirectFactory->create()->setPath('feedback/index');
    }
}
