<?php
/**
 *  * @author Robert Mark Williamson <robert@peasoup-development.com>
 *  * @company Peasoup Development Limited
 *
 */

namespace Peasoup\Storefinder\Controller\Adminhtml\Storefinder;

use Peasoup\Storefinder\Model\StoresFactory;
use Peasoup\Storefinder\Api\StoresRepositoryInterfaceFactory;
use Peasoup\Storefinder\Api\StoresImagesRepositoryInterfaceFactory;
use Peasoup\Storefinder\Api\Data\StoresInterfaceFactory;
use Peasoup\Storefinder\Api\Data\StoresImagesInterfaceFactory;
use \Magento\Framework\Api\SearchCriteriaInterfaceFactory;
use \Magento\Framework\Api\Filter;
use \Magento\Framework\Api\Search\FilterGroup;

class Save extends \Peasoup\Storefinder\Controller\Adminhtml\Storefinder
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;
    /**
     * @var StoresFactory
     */
    private $storesFactory;
    /**
     * @var StoresImagesFactory
     */
    private $storesImagesFactory;
    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    private $directoryList;
    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    private $fileUploaderFactory;
    /**
     * @var StoresRepositoryInterfaceFactory
     */
    private $storesRepositoryInterfaceFactory;

    /**
     * @var StoresInterfaceFactory
     */
    private $storesInterfaceFactory;
    /**
     * @var StoresImagesRepositoryInterfaceFactory
     */
    private $storesImagesRepositoryInterfaceFactory;
    /**
     * @var SearchCriteriaInterfaceFactory
     */
    private $searchCriteriaInterface;
    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var FilterGroup
     */
    private $filterGroups;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        StoresRepositoryInterfaceFactory $storesRepositoryInterfaceFactory,
        StoresImagesRepositoryInterfaceFactory $storesImagesRepositoryInterfaceFactory,
        StoresInterfaceFactory $storesInterfaceFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Peasoup\Storefinder\Model\ImageUploader $fileUploaderFactory,
        StoresImagesInterfaceFactory $storesImagesFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        SearchCriteriaInterfaceFactory $searchCriteriaInterface,
        Filter $filter,
        FilterGroup $filterGroups
    ) {
        parent::__construct($context, $coreRegistry);
        $this->resultPageFactory = $resultPageFactory;

        $this->storesImagesFactory = $storesImagesFactory;
        $this->directoryList = $directoryList;
        $this->fileUploaderFactory = $fileUploaderFactory;
        $this->storesRepositoryInterfaceFactory = $storesRepositoryInterfaceFactory;
        $this->storesInterfaceFactory = $storesInterfaceFactory;
        $this->storesImagesRepositoryInterfaceFactory = $storesImagesRepositoryInterfaceFactory;
        $this->searchCriteriaInterface = $searchCriteriaInterface;
        $this->filter = $filter;
        $this->filterGroups = $filterGroups;
    }

    /**
     * Create new item
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();



        if ($data) {
            $storesRepository = $this->storesRepositoryInterfaceFactory->create();

            $storesFactory = $this->storesInterfaceFactory->create();

            $id = false;

            if(array_key_exists('store_id',$data['storeinformation'])):
                $id = $data['storeinformation']['store_id'];
            endif;

            try {
                $storesFactory->saveData($data);
                $store = $storesRepository->save($storesFactory);
                $this->saveImages($store->getId(),$data);


                $this->messageManager->addSuccessMessage(__('Store saved successfully'));

                if ($this->getRequest()->getParam('back')) {

                    return $resultRedirect->setPath('*/*/edit', ['store_id' => $this->model->getStoreId()]);
                }
          //      return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e, __('Something went wrong while saving the Store.'));
                $this->messageManager->addErrorMessage($e->getMessage());
            }



            return $resultRedirect->setPath('*/*/index');
        }


    }

    public function deleteImages($storeId){

        $storesImagesRepository = $this->storesImagesRepositoryInterfaceFactory->create();
        $criteria = $this->searchCriteriaInterface->create();
        $filter=  $this->filter  ->setField("store_id")
            ->setValue($storeId)
            ->setConditionType("eq");
        $this->filterGroups ->setFilters([$filter]);
        $criteria = $criteria->setFilterGroups([$this->filterGroups]);
        $images = $storesImagesRepository->getList($criteria);

        if($images->getTotalCount() > 0 ) {
            $items =  $images->getItems();
            foreach($items as $item) {
                $storesImagesRepository->deleteById($item->getId());
            }
        }

    }


    public function saveImages($storeId,$data){

        //delete images

      $this->deleteImages($storeId);


        if(array_key_exists('images',$data)):

            $defaultImage=1;

            foreach($data['images']['image'] as $image) {

                $storesImagesRepository = $this->storesImagesRepositoryInterfaceFactory->create();

                $storesImagesFactory = $this->storesImagesFactory->create();
                //FILE DOES NOT EXIST IN FOLDER MOVE FORM TMP
                if( !$this->fileUploaderFactory->checkIfNew($image['name'])) {
                    try {
                        $this->fileUploaderFactory->moveFileFromTmp($image['name']);

                    } catch (\Exception $e) {
                        $this->messageManager->addErrorMessage($e, __('Something went wrong while saving the Images'));
                        $this->messageManager->addErrorMessage($e->getMessage());
                    }
                }
                try {
                    $storesImagesFactory->setData($image);
                    $storesImagesFactory->setImage($image['name']);
                    $storesImagesFactory->setDefaultImage($defaultImage);
                    $storesImagesFactory->setStoreId($storeId);
                    $storesImagesRepository->save($storesImagesFactory);
                    $defaultImage=0;
                }   catch (\Exception $e) {
                    $this->messageManager->addErrorMessage($e, __('Something went wrong while saving the Images'));
                    $this->messageManager->addErrorMessage($e->getMessage());
                }
            }
        endif;

    }



}