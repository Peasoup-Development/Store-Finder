<?php

namespace Peasoup\Storefinder\Controller\Adminhtml\Storefinder;

use Peasoup\Storefinder\Model\StoresFactory;

class Edit extends \Peasoup\Storefinder\Controller\Adminhtml\Storefinder
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    protected $resultPageFactory;
    /**
     * @var StoresFactory
     */
    private $storesFactory;
    /**
     * @var Session
     */
    private $backendSession;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Framework\View\Result\PageFactory $resultPageFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        StoresFactory $storesFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        $this->resultPageFactory = $resultPageFactory;


        $this->storesFactory = $storesFactory;
        $this->backendSession = $context->getSession();
        parent::__construct($context, $coreRegistry);
    }

    /**
     * Edit item
     *
     * @return \Magento\Framework\Controller\ResultInterface
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function execute()
    {


        // 1. Get ID and create model
        $id = $this->getRequest()->getParam('id');
        $model = $this->storesFactory->create();

        // 2. Initial checking
        if ($id) {
            $model->load($id);
            if (!$model->getId()) {
                $this->messageManager->addErrorMessage(__('This item no longer exists.'));
                /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
                $resultRedirect = $this->resultRedirectFactory->create();
                return $resultRedirect->setPath('*/*/');
            }
        }
        // 3. Set entered data if was error when we do save
        $data = $this->backendSession->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        // 4. Register model to use later in blocks
        $this->_coreRegistry->register('stores_item', $model);

        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();

        // 5. Build edit form
        $this->initPage($resultPage)->addBreadcrumb(
            $id ? __('Edit Item') : __('New Store'),
            $id ? __('Edit Item') : __('New Store')
        );
        $resultPage->getConfig()->getTitle()->prepend(__('Items'));
        $resultPage->getConfig()->getTitle()->prepend($model->getId() ? $model->getName() : __('New Store'));
        return $resultPage;
    }
}