<?php

namespace MagentoAssignment\FeedbackForm\Api\Data;

interface GridInterface
{
    /**
     * Constants for keys of data array. Identical to the name of the getter in snake case.
     */
    const ID = 'id';
    const NAME = 'name';
    const EMAIL = 'email';
    const TELEPHONE = 'telephone';
    const COMMENT = 'comment';
    const UPDATED_AT = 'updated_at';
    const CREATED_AT = 'created_at';

    /**
     * Get id.
     * @return int
     */
    public function getId();

    /**
     * Set id.
     */
    public function setId($id);

    /**
     * Get name.
     * @return string
     */
    public function getName();

    /**
     * Set Title.
     */
    public function setName($name);

    /**
     * Get email.
     * @return string
     */
    public function getEmail();

    /**
     * Set email.
     */
    public function setEmail($email);

    /**
     * Get $telephone number.
     * @return string
     */
    public function getTelephone();

    /**
     * Set $telephone number.
     */
    public function setTelephone($telephone);

    /**
     * Get comment.
     * @return string
     */
    public function getComment();

    /**
     * Set comment.
     */
    public function setComment($comment);

    /**
     * Get UpdateTime.
     * @return string
     */
    public function getUpdatedAt();

    /**
     * Set UpdateTime.
     */
    public function setUpdatedAt($updatedAt);

    /**
     * Get CreatedAt.
     * @return string
     */
    public function getCreatedAt();

    /**
     * Set CreatedAt.
     */
    public function setCreatedAt($createdAt);
}
