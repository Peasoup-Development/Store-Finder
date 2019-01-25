<?php

namespace Peasoup\Storefinder\Model;


use Magento\Framework\DataObject\IdentityInterface;
use Peasoup\Storefinder\Api\Data\StoresImagesInterface;


class StoresImages  extends \Magento\Framework\Model\AbstractModel implements  StoresImagesInterface,IdentityInterface {

    const CACHE_TAG = 'STOREFINDER_IMAGES';


    /**
     * List of attributes in StoresInterface
     * @var array
     */
    protected $interfaceAttributes = [
        StoresImagesInterface::ID,
        StoresImagesInterface::IMAGE,
        StoresImagesInterface::DEFAULTIMAGE,
        StoresImagesInterface::STOREID,

    ];

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


    /**
     * @return string
     */
    public function getCustomName()
    {
        // TODO: Implement getCustomName() method.
    }

    /**
     * @param string $customName
     * @return $this
     */
    public function setCustomName($customName)
    {
        // TODO: Implement setCustomName() method.
    }

    /**
     * @return string
     */
    public function getImage()
    {
        return $this->_getData(self::IMAGE);
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image)
    {
        return $this->setData(self::IMAGE, $image);
    }

    /**
     * @return string
     */
    public function getDefaultImage()
    {
        return $this->_getData(self::DEFAULTIMAGE);
    }

    /**
     * @param string $defaultImage
     * @return $this
     */
    public function setDefaultImage($defaultImage)
    {
        return $this->setData(self::DEFAULTIMAGE, $defaultImage);
    }

    /**
     * @param string $store_id
     * @return $this
     */
    public function getStoreId($store_id)
    {
        return $this->_getData(self::STOREID);
    }

    /**
     * @param string $image
     * @return $this
     */
    public function setStoreId($store_id)
    {
        return $this->setData(self::STOREID, $store_id);
    }
}