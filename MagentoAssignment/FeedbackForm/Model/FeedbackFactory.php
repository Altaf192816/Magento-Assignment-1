<?php
namespace MagentoAssignment\FeedbackForm\Model;

use Magento\Framework\ObjectManagerInterface;

class FeedbackFactory
{
    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    public function __construct(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * Create and return Feedback model instance
     * @param array $data
     * @return Feedback
     */
    public function create(array $data = [])
    {
        return $this->objectManager->create(Feedback::class, ['data' => $data]);
    }
}
