<?php
namespace Peasoup\Storefinder\Model\Stores;
use Peasoup\Storefinder\Model\ResourceModel\Stores\CollectionFactory;

use Peasoup\Storefinder\Api\StoresRepositoryInterfaceFactory;

use Peasoup\Storefinder\Api\StoresImagesRepositoryInterfaceFactory;

use \Magento\Framework\Api\SearchCriteriaInterfaceFactory;
use \Magento\Framework\Api\Filter;
use \Magento\Framework\Api\Search\FilterGroup;
use \Magento\Store\Model\StoreManagerInterface;
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @var StoresRepositoryInterfaceFactory
     */
    private $storesRepositoryInterfaceFactory;
    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteriaInterface;
    /**
     * @var StoresImagesRepositoryInterfaceFactory
     */
    private $storesImagesRepositoryInterfaceFactory;
    /**
     * @var Filter
     */
    private $filter;
    /**
     * @var FilterGroups
     */
    private $filterGroups;
    /**
     * @var StoreManagerInterface
     */
    private $storeManagerInterface;

    private $storefinderpath = 'storefinder/store/';

    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        StoresRepositoryInterfaceFactory $storesRepositoryInterfaceFactory,
        StoresImagesRepositoryInterfaceFactory $storesImagesRepositoryInterfaceFactory,
        SearchCriteriaInterfaceFactory $searchCriteriaInterface,
        StoreManagerInterface $storeManagerInterface,
        Filter $filter,
        FilterGroup $filterGroups,
        array $meta = [],
        array $data = []
    ) {


        $this->collection = $contactCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->storesRepositoryInterfaceFactory = $storesRepositoryInterfaceFactory;
        $this->searchCriteriaInterface = $searchCriteriaInterface;
        $this->storesImagesRepositoryInterfaceFactory = $storesImagesRepositoryInterfaceFactory;
        $this->filter = $filter;
        $this->filterGroups = $filterGroups;
        $this->storeManagerInterface = $storeManagerInterface;
    }


    public function getData()
    {



        //ADD JOIN CRITERIA AND LINK IMAGES TO BE DISPLAYED

        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $criteria = $this->searchCriteriaInterface->create();



        $this->collection = $this->storesRepositoryInterfaceFactory->create()->getList($criteria);

        $this->storeManagerInterface->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
        $items = $this->collection->getItems();

        $images = $this->storesImagesRepositoryInterfaceFactory->create();

        $this->loadedData = array();

        foreach ($items as $store) {
            $imagesReturned =[];
            $filter=  $this->filter  ->setField("store_id")
                ->setValue($store->getId())
                ->setConditionType("eq");


            $this->filterGroups ->setFilters([$filter]);

            $criteria = $criteria->setFilterGroups([$this->filterGroups]);

            $imagesReturned = $images->getList($criteria)->getItems();

            foreach($this->getFieldsMap() as $group=>$data) {
                foreach($data as $junk=>$fieldName) {
                    $this->loadedData[$store->getId()][$group][$fieldName] = $store->getData($fieldName);
                }
            }

//            $this->loadedData[$store->getId()]['mapsettings']['postcode-new'] = $store->getData('postcode');

            if(count($imagesReturned) > 0) {
                $m = [];
                $count = 0;

            foreach ($imagesReturned as $key => $image) {
                $m['image'][$count]['name'] = $image->getImage();
                $m['image'][$count]['url'] = $this->storeManagerInterface->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) . $this->storefinderpath . $image->getImage();
                $count++;
            }

            $this->loadedData[$store->getId()]['images'] = $m;
            }
        }

        return $this->loadedData;
    }

    protected function getFieldsMap()
    {
        return [
            'storeinformation' => [
                'store_id',
                'name',
                'synopsis',
                'notes',
            ],
            'addressdetails' => [
                'address1',
                'address2',
                'town',
                'country',
                'postcode',
            ],
            'contactdetails' => [
                'email',
                'telephone',
            ],
            'openinghours' => [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday',
                'bank',
            ],
            'socialsettings' => [
                'facebook_page_id',
                'facebook_access_token',
                'placeId',
            ],
            'mapsettings' => [
                'postcode-new',
                'longitude',
                'latitude',
            ]
        ];
    }



}