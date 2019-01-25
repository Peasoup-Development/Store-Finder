<?php
/**
 *  * @author Robert Mark Williamson <robert@peasoup-development.com>
 *  * @company Peasoup Development Limited
 *
 */

namespace Peasoup\Storefinder\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface StoresImagesSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Peasoup\Storefinder\Api\Data\StoresImagesInterface[]
     */
    public function getItems();

    /**
     * @param \Peasoup\Storefinder\Api\Data\StoresImagesInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}