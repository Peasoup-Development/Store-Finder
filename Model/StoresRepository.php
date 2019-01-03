<?php
/**
 * THIS IS THE REPOSITORY
 */

Namespace Peasoup\Storefinder\Model;

use Magento\Framework\Api\SortOrder;
use Magento\Framework\Exception\NoSuchEntityException;
use Peasoup\Storefinder\Api\Data;
use Peasoup\Storefinder\Api\StoresRepositoryInterface;
use Peasoup\Storefinder\Model\ResourceModel\Stores as StoresResource;
use Peasoup\Storefinder\Model\ResourceModel\Stores\CollectionFactory;

class StoresRepository implements StoresRepositoryInterface
{

    /**
     * @var storesResource
     */
    private $storesResource;
    /**
     * @var storesFactory
     */
    private $storesFactory;
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var CustomSearchResultsInterfaceFactory
     */
    private $searchResultsFactory;

    public function __construct(
        StoresResource $customResource,
        StoresFactory $customFactory,
        CollectionFactory $collectionFactory
    )
    {
        $this->storesResource = $customResource;
        $this->storesFactory = $customFactory;
        $this->collectionFactory = $collectionFactory;
    }
    /**
 * @param $customId
 * @return \Peasoup\Storefinder\Api\Data\CustomInterface int
 * @throws \Magento\Framework\Exception\NoSuchEntityException
 */
    public function getById($storeId)
    {
        $store = $this->storesFactory->create();
        $this->storesResource->load($store, $storeId);

        if(!$store->getId()) {
            throw new NoSuchEntityException('Store does not exist');
        }
        return $store;
    }

    /**
     * @param $customId
     * @return \Peasoup\Storefinder\Api\Data\CustomInterface int
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getStoreAndImages($storeId)
    {
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
    }
}