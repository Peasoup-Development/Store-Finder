<?php
namespace Peasoup\Storefinder\Controller\Adminhtml\Storefinder;

use Peasoup\Storefinder\Model\StoresFactory;

use Magento\Backend\App\Action;

class Delete extends \Magento\Backend\App\Action
{


    /**
     * @var ReviewsFactory
     */
    private $reviewsFactory;

    public function __construct(
        Action\Context $context,
        StoresFactory $reviewsFactory
    )
    {
        parent::__construct($context);
        $this->storeFactory = $reviewsFactory->create();
    }

    public function execute()
    {
        $id = $this->getRequest()->getParam('id');


        if (!($review =  $this->storeFactory->load($id))) {
            $this->messageManager->addErrorMessage(__('Unable to proceed. Please, try again.'));
            $resultRedirect = $this->resultRedirectFactory->create();
            return $resultRedirect->setPath('*/*/index', array('_current' => true));
        }
        try{

            $review->delete();
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