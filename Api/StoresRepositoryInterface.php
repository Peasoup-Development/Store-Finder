<?php

namespace Peasoup\Storefinder\Api;

interface StoresRepositoryInterface
{
    /**
     * Createstore
     *
     * @param \Peasoup\Storefinder\Api\Data\StoresInterface $store
     * @return \Peasoup\Storefinder\Api\Data\StoresInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Peasoup\Storefinder\Api\Data\StoresInterface $store);

    /**
     * Get info about store by store
     *
     * @param string $store
     * @return \Peasoup\Storefinder\Api\Data\StoresInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($store);

    /**
     * Get info about device by store_id
     *
     * @param int $storeId
     * @return \Peasoup\Storefinder\Api\Data\StoresInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($storeId);

    /**
     * Delete store
     *
     * @param \Peasoup\Storefinder\Api\Data\StoresInterface $store
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Peasoup\Storefinder\Api\Data\StoresInterface $store);

    /**
     * @param string $storeId
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($storeId);

    /**
     * Get product list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}