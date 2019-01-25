<?php

namespace Peasoup\Storefinder\Controller\Index;

use Peasoup\Storefinder\Model\StoresFactory;
use Peasoup\Storefinder\Model\StoresRepository;
use Peasoup\Storefinder\Api\StoresRepositoryInterfaceFactory;
use \Magento\Framework\Api\SearchCriteriaInterface;
use Peasoup\Storefinder\Model\StoresimagesFactory;
use \Magento\Framework\Api\SortOrder;

class Stores extends \Magento\Framework\App\Action\Action
{
    protected $_storesFactory;
    protected $_resultJson;
    protected $_storesRepository;
    protected $_request;
    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteriaInterface;
    /**
     * @var SortOrder
     */
    private $sortOrder;

    /**
     * @var StoresimagesFactory
     */
    private $storesimagesFactory;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\App\Request\Http $request,
        StoresimagesFactory $storesimagesFactory,
        StoresRepositoryInterfaceFactory $storesRepositoryInterfaceFactory,
        SearchCriteriaInterface $searchCriteriaInterface,
        StoresFactory $storesFactory,
        SortOrder $sortOrder
    )
    {
        $this->_storesFactory = $storesFactory;
        $this->_resultJson =  $resultJsonFactory;
        $this->_request =  $request;
        $this->_storesRepository = $storesRepositoryInterfaceFactory;
        parent::__construct($context);
        $this->searchCriteriaInterface = $searchCriteriaInterface;
        $this->sortOrder = $sortOrder;
        $this->storesimagesFactory = $storesimagesFactory;
    }

    public function execute() {

        $id = $this->_request->getParam('id');
        if(isset($id))
        {

            $store = $this->_storesRepository->create()->getById($id);
            $imagesFactory= $this->storesimagesFactory->create();
            $data = [];
            $storeId = $store->getStoreId();
            $data[$storeId] = $store->getData();

            $images = $imagesFactory->getCollection()
                ->addFieldToFilter(
                    'store_id',
                    ['eq' => $store->getStoreId()]
                )->setOrder('default_image','DESC');

            $data[$storeId]['images'] = $images->getData();

            $resultJson = $this->_resultJson->create();
            return $resultJson->setData($data);
        }
        else
        {

           $sortOrder=  $this->sortOrder ->setField("store_id")
               ->setDirection("ASC");

           $this->searchCriteriaInterface->setSortOrders([$sortOrder]);

           $data = [];
           $collection = $this->_storesRepository->create()->getList($this->searchCriteriaInterface);

           $items = $collection->getItems();
           $imagesFactory= $this->storesimagesFactory->create();

           foreach($items as $key=>$value) {
               $storeId = $value->getStoreId();
               $data[$storeId] = $value->getData();

               $images = $imagesFactory->getCollection()
                   ->addFieldToFilter(
                       'store_id',
                       ['eq' => $value->getStoreId()]
                   )->setOrder('default_image','DESC');

               $data[$storeId]['images'] = $images->getData();
           }

           $resultJson = $this->_resultJson->create();
           return $resultJson->setData($data);
        }
    }
}