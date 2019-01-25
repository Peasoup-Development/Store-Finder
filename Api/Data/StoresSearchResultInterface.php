<?php
/**
 *  * @author Robert Mark Williamson <robert@peasoup-development.com>
 *  * @company Peasoup Development Limited
 *
 */

namespace Peasoup\Storefinder\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface StoresSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Peasoup\Storefinder\Api\Data\StoresInterface[]
     */
    public function getItems();

    /**
     * @param \Peasoup\Storefinder\Api\Data\StoresInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}