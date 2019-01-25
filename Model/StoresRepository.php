<?php

namespace Peasoup\Storefinder\Model;

ini_set('display_errors',1);
use Magento\Framework\Exception\NoSuchEntityException;
use Peasoup\Storefinder\Api\StoresRepositoryInterface;
use Peasoup\Storefinder\Api\Data\StoresInterfaceFactory;
use Peasoup\Storefinder\Api\Data\StoresSearchResultInterface;
use Peasoup\Storefinder\Api\Data\StoresSearchResultInterfaceFactory;
use Peasoup\Storefinder\Model\ResourceModel\Stores\CollectionFactory as StoreCollectionFactory;
use Peasoup\Storefinder\Model\ResourceModel\Stores\Collection;
use \Magento\Framework\Exception\CouldNotDeleteException;
use \Magento\Framework\Api\SortOrder;

class StoresRepository implements StoresRepositoryInterface
{


    private $storesInterfaceFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var StoresSearchResultInterface
     */
    private $storesSearchResultInterfaceFactory;

    /**
     * StoresRepository constructor.
     * @param StoresInterfaceFactory $storesInterfaceFactory
     */
    public function __construct(
        StoresInterfaceFactory $storesInterfaceFactory,
        StoresSearchResultInterfaceFactory $storesSearchResultInterfaceFactory,
        StoreCollectionFactory $collectionFactory
    ) {
        $this->storesInterfaceFactory = $storesInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->storesSearchResultInterfaceFactory = $storesSearchResultInterfaceFactory;
    }

    /**
     * Create store
     *
     * @param \Peasoup\Storefinder\Api\Data\StoresInterface $store
     * @return \Peasoup\Storefinder\Api\Data\StoresInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Peasoup\Storefinder\Api\Data\StoresInterface $store)
    {
        $storeFactory = $this->storesInterfaceFactory->create();
        $storeFactory->getResource()->save($store);
        return $store;
    }

    /**
     * Get info about store by store
     *
     * @param string $store
     * @return \Peasoup\Storefinder\Api\Data\StoresInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($store)
    {
        // TODO: Implement get() method.
    }

    /**
     * Get info about device by store_id
     *
     * @param int $storeId
     * @return \Peasoup\Storefinder\Api\Data\StoresInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($storeId)
    {
        $store = $this->storesInterfaceFactory->create();
        $store->getResource()->load($store, $storeId);

        if (! $store->getId()) {
            return false;
        }
        return $store;
    }

    /**
     * Delete store
     *
     * @param \Peasoup\Storefinder\Api\Data\StoresInterface $store
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Peasoup\Storefinder\Api\Data\StoresInterface $store)
    {
        $storeFactory = $this->storesInterfaceFactory->create();
        try {
            $storeFactory->getResource()->delete($store);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }

    /**
     * @param string $storeId
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($storeId)
    {
        $storeFactory = $this->storesInterfaceFactory->create();
        try {
            $store =  $this->getById($storeId);
            $storeFactory->getResource()->delete($store);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
    }



    /**
     * @param $storeId
     * @return \Peasoup\Storefinder\Api\Data\CustomInterface int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreAndImages($storeId)
    {

        /*
        $collection = $this->storesFactory->create()->getCollection();
        $joinConditions[] = 'main_table.store_id = vdi.store_id';
        $joinConditions[] = "vdi.default_image = '1'";
        $joinConditions = implode(
            ' AND ', $joinConditions
        );
        $collection->getSelect()->joinLeft(
            [
                'vdi' => $collection->getTable('vapedirect_storefinder_images')
            ],
            $joinConditions,
            [
                'image' => 'vdi.image'
            ]
        );
        $collection->addFieldToFilter('main_table.store_id', array('eq' =>$storeId))->addFieldToSelect(array('*'));
        return $collection;

        */
    }


    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addFiltersToCollection(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        foreach ($searchCriteria->getFilterGroups() as $filterGroup) {
            $fields = $conditions = [];
            foreach ($filterGroup->getFilters() as $filter) {
                $fields[] = $filter->getField();
                $conditions[] = [$filter->getConditionType() => $filter->getValue()];
            }
            $collection->addFieldToFilter($fields, $conditions);
        }
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addSortOrdersToCollection(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, Collection $collection)
    {

        foreach ((array) $searchCriteria->getSortOrders() as $sortOrder) {
            $direction = $sortOrder->getDirection() == SortOrder::SORT_ASC ? 'asc' : 'desc';
            $collection->addOrder($sortOrder->getField(), $direction);
        }
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     */
    private function addPagingToCollection(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $collection->setPageSize($searchCriteria->getPageSize());
        $collection->setCurPage($searchCriteria->getCurrentPage());
    }

    /**
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @param Collection $collection
     * @return mixed
     */
    private function buildSearchResult(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria, Collection $collection)
    {
        $searchResults = $this->storesSearchResultInterfaceFactory->create();

        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }


    /**
     * Get product list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria)
    {
        $collection = $this->collectionFactory->create();

        $collection->addFieldToSelect('*');
        $this->addFiltersToCollection($searchCriteria, $collection);
        $this->addSortOrdersToCollection($searchCriteria, $collection);
        $this->addPagingToCollection($searchCriteria, $collection);

        $collection->load();

        return $this->buildSearchResult($searchCriteria, $collection);
    }
}