<?php
/**
 *  * @author Robert Mark Williamson <robert@peasoup-development.com>
 *  * @company Peasoup Development Limited
 *
 */

namespace Peasoup\Storefinder\Model;

use Magento\Framework\Api\SearchResults;
use Peasoup\Storefinder\Api\Data\StoresSearchResultInterface;

class StoresSearchResult extends SearchResults implements StoresSearchResultInterface
{

    private $_items;

    /**
     * @return \Peasoup\Storefinder\Api\Data\StoresInterface[]
     */
    public function getItems()
    {
        return $this->_items;
    }

    /**
     * @param \Peasoup\Storefinder\Api\Data\StoresInterface[] $items
     * @return void
     */
    public function setItems(array $items)
    {
         $this->_items = $items;
    }
}