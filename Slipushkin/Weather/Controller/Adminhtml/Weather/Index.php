<?php

declare(strict_types=1);

namespace Slipushkin\Weather\Controller\Adminhtml\Weather;

use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\View\Result\Page;
use Magento\Framework\View\Result\PageFactory;

class Index extends Action
{
    /**
     * @var bool|PageFactory
     */
    protected $factory = false;

    /**
     * @param Action\Context $context
     * @param PageFactory $factory
     */
    public function __construct(
        Action\Context $context,
        PageFactory $factory
    ) {
        parent::__construct($context);
        $this->factory = $factory;
    }

    /**
     * @return ResponseInterface|ResultInterface|Page
     */
    public function execute()
    {
        $page = $this->factory->create();
        $page->getConfig()->getTitle()->prepend((__('Weather')));

        return $page;
    }
}
