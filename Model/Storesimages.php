<?php

namespace Peasoup\Storefinder\Model;


use Magento\Framework\DataObject\IdentityInterface;


class Storesimages  extends \Magento\Framework\Model\AbstractModel implements  IdentityInterface {

    const CACHE_TAG = 'STOREFINDER_IMAGES';

    /**
    * Define resource model
    */
    protected function _construct() {
        $this->_init('Peasoup\Storefinder\Model\ResourceModel\Storesimages');
    }


    /**
     * Return unique ID(s) for each object in system
     *
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }


}