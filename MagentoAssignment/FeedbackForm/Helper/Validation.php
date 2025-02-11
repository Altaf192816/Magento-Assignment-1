<?php

namespace MagentoAssignment\FeedbackForm\Helper;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\Exception\LocalizedException;

class Validation extends AbstractHelper
{
    /**
     * Validate Name Only letters, numbers, and spaces allowed
     * @param string $name
     * @throws LocalizedException
     */
    public function validateName(string $name)
    {
        if (empty($name) || !preg_match('/^[a-zA-Z0-9\s]+$/', $name)) {
            throw new LocalizedException(__('Invalid name. Only letters, numbers, and spaces are allowed.'));
        }
    }

    /**
     * Validate Email Address
     * @param string $email
     * @throws LocalizedException
     */
    public function validateEmail(string $email)
    {
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new LocalizedException(__('Invalid email address.'));
        }
    }

    /**
     * Validate Telephone Only Numbers Allowed
     * @param string $telephone
     * @throws LocalizedException
     */
    public function validateTelephone(string $telephone)
    {
        if (empty($telephone) || !preg_match('/^[0-9]+$/', $telephone)) {
            throw new LocalizedException(__('Invalid telephone number. Only numbers are allowed.'));
        }
    }
}
