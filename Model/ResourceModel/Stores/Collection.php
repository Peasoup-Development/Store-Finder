<?php

namespace Peasoup\Storefinder\Model\ResourceModel\Stores;


class Collection extends \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection
{
    protected function _construct()
    {
        $this->_init('Peasoup\Storefinder\Model\Stores', 'Peasoup\Storefinder\Model\ResourceModel\Stores');
    }
}
