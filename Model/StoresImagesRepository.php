<?php
/**
 *  * @author Robert Mark Williamson <robert@peasoup-development.com>
 *  * @company Peasoup Development Limited
 *
 */

namespace Peasoup\Storefinder\Model;


use Magento\Framework\Exception\NoSuchEntityException;
use Peasoup\Storefinder\Api\StoresImagesRepositoryInterface;
use Peasoup\Storefinder\Api\Data\Peasoup\Storefinder\Api\Data\StoresInterfaceFactory;
use Peasoup\Storefinder\Api\Data\StoresSearchResultInterface;
use Peasoup\Storefinder\Api\Data\StoresImagesSearchResultInterfaceFactory;
use Peasoup\Storefinder\Api\Data\StoresImagesInterfaceFactory;
use Peasoup\Storefinder\Model\ResourceModel\Storesimages\CollectionFactory as ImagesCollectionFactory;
use Peasoup\Storefinder\Model\ResourceModel\Storesimages\Collection;
use \Magento\Framework\Exception\CouldNotDeleteException;
use \Magento\Framework\Exception\CouldNotSaveException;
use \Magento\Framework\Api\SortOrder;

class StoresImagesRepository implements StoresImagesRepositoryInterface
{


    private $storesImagesInterfaceFactory;
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
        StoresImagesInterfaceFactory $storesImagesInterfaceFactory,
        StoresImagesSearchResultInterfaceFactory $storesSearchResultInterfaceFactory,
        ImagesCollectionFactory $collectionFactory
    ) {
        $this->storesImagesInterfaceFactory = $storesImagesInterfaceFactory;
        $this->collectionFactory = $collectionFactory;
        $this->storesSearchResultInterfaceFactory = $storesSearchResultInterfaceFactory;
    }

    /**
     * Create Image
     *
     * @param \Peasoup\Storefinder\Api\Data\StoresImagesInterface $image
     * @return \Peasoup\Storefinder\Api\Data\StoresInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Peasoup\Storefinder\Api\Data\StoresImagesInterface $image)
    {

        $storeImagesFactory = $this->storesImagesInterfaceFactory->create();

        try {

            $storeImagesFactory->getResource()->save($image);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(__($exception->getMessage()));
        }

        return $image;
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
        $store = $this->storesImagesInterfaceFactory->create();
        $store->getResource()->load($store, $storeId);

        if (! $store->getId()) {
            return false;
        }
        return $store;
    }

    /**
     * Delete store
     *
     * @param \Peasoup\Storefinder\Api\Data\StoresInterface $image
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Peasoup\Storefinder\Api\Data\StoresImagesInterface $image)
    {
        $storeFactory = $this->storesImagesInterfaceFactory->create();
        try {
            $storeFactory->getResource()->delete($image);
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
        $storeFactory = $this->storesImagesInterfaceFactory->create();
        try {
            $store =  $this->getById($storeId);
            $storeFactory->getResource()->delete($store);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }
        return true;
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