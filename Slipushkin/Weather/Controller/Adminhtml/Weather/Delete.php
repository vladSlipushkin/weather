<?php

declare(strict_types=1);

namespace Slipushkin\Weather\Controller\Adminhtml\Weather;

use Exception;
use Magento\Backend\App\Action;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Redirect;
use Magento\Framework\Controller\ResultInterface;
use Magento\Ui\Component\MassAction\Filter;
use Slipushkin\Weather\Model\ResourceModel\Weather\Collection;
use Magento\Backend\App\Action\Context;
use Psr\Log\LoggerInterface;

class Delete extends Action
{
    /**
     * @var Filter
     */
    protected Filter $filter;

    /**
     * @var Collection
     */
    protected Collection $collection;

    /**
     * @var LoggerInterface
     */
    private LoggerInterface $logger;

    /**
     * @param Filter $filter
     * @param Collection $collection
     * @param Context $context
     * @param LoggerInterface $logger
     */
    public function __construct(
        Filter $filter,
        Collection $collection,
        Context $context,
        LoggerInterface $logger
    ) {
        $this->filter = $filter;
        $this->collection = $collection;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @return ResponseInterface|Redirect|ResultInterface
     */
    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collection);

            foreach ($collection as $item) {
                $item->delete();
            }

            $this->messageManager->addSuccessMessage(__('Record Deleted Successfully.'));
        } catch (Exception $e) {
            $this->logger->error($e->getMessage());
            $this->messageManager->addErrorMessage(__('Cannot Delete The Record'));
        }

        $resultRedirect = $this->resultRedirectFactory->create();

        return $resultRedirect->setPath('slipushkin_weather/weather/index');
    }

    /**
     * @return bool
     */
    protected function isAllowed(): bool
    {
        return $this->_authorization->isAllowed('Slipushkin_Weather::weather');
    }
}
