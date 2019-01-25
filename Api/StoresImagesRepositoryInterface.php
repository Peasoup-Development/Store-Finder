<?php
/**
 *  * @author Robert Mark Williamson <robert@peasoup-development.com>
 *  * @company Peasoup Development Limited
 *
 */

namespace Peasoup\Storefinder\Api;

interface StoresImagesRepositoryInterface
{
    /**
     * Create images
     *
     * @param \Peasoup\Storefinder\Api\Data\StoresImagesInterface $image
     * @return \Peasoup\Storefinder\Api\Data\StoresImagesInterface
     * @throws \Magento\Framework\Exception\InputException
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(\Peasoup\Storefinder\Api\Data\StoresImagesInterface $image);

    /**
     * Get info about images
     *
     * @param string $image
     * @return \Peasoup\Storefinder\Api\Data\StoresImagesInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function get($image);

    /**
     * Get info about image by image_id
     *
     * @param int $image_id
     * @return \Peasoup\Storefinder\Api\Data\StoresImagesInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($image_id);

    /**
     * Delete store
     *
     * @param \Peasoup\Storefinder\Api\Data\StoresInterface $store
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\StateException
     */
    public function delete(\Peasoup\Storefinder\Api\Data\StoresImagesInterface $image);

    /**
     * @param string $image_id
     * @return bool Will returned True if deleted
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     * @throws \Magento\Framework\Exception\StateException
     */
    public function deleteById($image_id);

    /**
     * Get product list
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Catalog\Api\Data\ProductSearchResultsInterface
     */
    public function getList(\Magento\Framework\Api\SearchCriteriaInterface $searchCriteria);
}