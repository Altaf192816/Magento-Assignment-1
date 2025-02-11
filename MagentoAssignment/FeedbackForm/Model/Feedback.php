<?php

namespace MagentoAssignment\FeedbackForm\Model;

use Magento\Framework\Model\AbstractModel;
use MagentoAssignment\FeedbackForm\Api\Data\GridInterface;
use MagentoAssignment\FeedbackForm\Model\ResourceModel\Feedback as FeedbackResource;

class Feedback extends AbstractModel implements GridInterface
{
    /**
     * CMS page cache tag.
     */
    const CACHE_TAG = 'feedback';
    /**
     * @var string
     */
    protected $_cacheTag = 'feedback';
    /**
     * Prefix of model events names.
     * @var string
     */
    protected $_eventPrefix = 'feedback';

    protected function _construct()
    {
        $this->_init(FeedbackResource::class);
    }

    public function getId()
    {
        return $this->getData(self::ID);
    }

    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    public function getName()
    {
        return $this->getData(self::NAME);
    }

    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    public function getEmail()
    {
        return $this->getData(self::EMAIL);
    }

    public function setEmail($email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    public function getTelephone()
    {
        return $this->getData(self::TELEPHONE);
    }

    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    public function getComment()
    {
        return $this->getData(self::COMMENT);
    }

    public function setComment($comment)
    {
        return $this->setData(self::COMMENT, $comment);
    }

    public function getUpdatedAt()
    {
        return $this->getData(self::UPDATED_AT);
    }

    public function setUpdatedAt($updatedAt)
    {
        return $this->setData(self::UPDATED_AT, $updatedAt);
    }

    public function getCreatedAt()
    {
        return $this->getData(self::CREATED_AT);
    }

    public function setCreatedAt($createdAt)
    {
        return $this->setData(self::CREATED_AT, $createdAt);
    }
}
