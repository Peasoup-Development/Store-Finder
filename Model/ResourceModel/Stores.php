<?php

namespace Peasoup\Storefinder\Model\ResourceModel;

class Stores extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{






    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('vapedirect_storefinder', 'store_id');
    }

    /**
     * Retrieves Post Name from DB by passed id.
     *
     * @param string $id
     * @return string|bool
     */
    public function getStoreById($id)
    {
        $adapter = $this->getConnection();
        $select = $adapter->select()
            ->from($this->getMainTable(), '*')
            ->where('store_id = :store_id');
        $binds = ['store_id' => (int) $id];
        return $adapter->fetchOne($select, $binds);
    }

}