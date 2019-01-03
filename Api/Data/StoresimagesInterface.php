<?php
/**
 * THIS IS THE DATA CONTAINER
 *
 */

namespace Peasoup\Storefinder\Api\Data;

/**
 * Interface CustomInterface
 * @package Namespace\Custom\api\Data
 * @api
 */
interface StoresimagesInterface
{
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
    public function getCustomName();

    /**
     * @param string $customName
     * @return $this
     */
    public function setCustomName($customName);
}