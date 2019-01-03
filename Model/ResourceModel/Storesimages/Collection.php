<?php

namespace Peasoup\Storefinder\Model\ResourceModel\Storesimages;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Peasoup\Storefinder\Model\Storesimages', 'Peasoup\Storefinder\Model\ResourceModel\Storesimages');
    }
}
