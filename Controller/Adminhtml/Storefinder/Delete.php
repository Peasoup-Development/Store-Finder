<?php
namespace Peasoup\Storefinder\Controller\Adminhtml\Storefinder;

use Peasoup\Storefinder\Api\StoresRepositoryInterfaceFactory;

use Magento\Backend\App\Action;

class Delete extends \Magento\Backend\App\Action
{


    /**
     * @var StoresRepositoryInterfaceFactory
     */
    private $storesRepositoryInterfaceFactory;

    public function __construct(
        Action\Context $context,
        StoresRepositoryInterfaceFactory $storesRepositoryInterfaceFactory
    )
    {
        parent::__construct($context);
        $this->storesRepositoryInterfaceFactory = $storesRepositoryInterfaceFactory;
    }

    public function execute()
    {

        $id = $this->getRequest()->getParam('id');

        $storeRepositoryInterfaceFactory = $this->storesRepositoryInterfaceFactory->create();

        if (!($store =  $storeRepositoryInterfaceFactory->getById($id))) {
            $this->messageManager->addErrorMessage(__('Unable to proceed. Please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }
        try {

            $storeRepositoryInterfaceFactory->delete($store);

            $this->messageManager->addSuccessMessage(__('Store deleted'));
        } catch (Exception $e) {
            $this->messageManager->addErrorMessage(__('Error while trying to delete store: '));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }

        $resultRedirect = $this->resultRedirectFactory->create();
        return $resultRedirect->setPath('*/*/index', array('_current' => true));
    }
}