<?php

namespace Peasoup\Storefinder\Controller\Index;

use Peasoup\Storefinder\Model\StoresRepository;

class Search extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $_searchretailers;
    protected $_resultJson;

    protected $_stores;
    /**
     * @var StoresRepository
     */
    protected $storesRepository;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        StoresRepository $storesRepository,
        \Peasoup\Storefinder\Model\Postcodeanywhere\Searchretailer $searchretailers
        )
    {
            $this->_searchretailers = $searchretailers;
            $this->_resultPageFactory = $resultPageFactory;
            $this->_resultJson =  $resultJsonFactory;
            parent::__construct($context);
            $this->storesRepository = $storesRepository;
    }

    public function execute() {
        $postcode = $this->getRequest()->getParam('postcode');
        $miles = $this->getRequest()->getParam('miles');
       // $miles = $this->getRequest()->getParam('miles');

        $kilometeres = $miles * 1.609344;

        $this->_searchretailers->setFinderData("XG71-CE61-FX94-JR82",$postcode,0,$kilometeres,120,"StraightLine","7006");
        $this->_searchretailers->makeSearchRequest();
        $resultJson = $this->_resultJson->create();
        $data = $this->_searchretailers->HasDataReturned();
        if(! $data){

        }
        else {
            foreach ($data as $store) {
                $shop = $this->storesRepository->getStoreAndImages($store['entity_id'])->getData();
                $this->_stores[] = $shop[0];
            }
        }
        return $resultJson->setData($this->_stores);
    }
}