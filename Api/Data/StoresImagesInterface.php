<?php
/**
 *  * @author Robert Mark Williamson <robert@peasoup-development.com>
 *  * @company Peasoup Development Limited
 *
 */

namespace Peasoup\Storefinder\Api\Data;

/**
 * Interface StoresImagesInterface
 * @package Namespace\Custom\api\Data
 * @api
 */
interface StoresImagesInterface
{

    const ID = 'image_id';
    const IMAGE = 'image';
    const DEFAULTIMAGE = 'default_image';
    const STOREID = 'store_id';

    /**
     * @return int
     */
    public function getId();

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id);

    /**
     * @return string
     */
    public function getImage();

    /**
     * @param string $image
     * @return $this
     */
    public function setImage($image);

    /**
     * @return string
     */
    public function getDefaultImage();

    /**
     * @param string $defaultImage
     * @return $this
     */
    public function setDefaultImage($defaultImage);

    /**
     * @param string $store_id
     * @return $this
     */
    public function getStoreId($store_id);

    /**
     * @param string $image
     * @return $this
     */
    public function setStoreId($store_id);
}