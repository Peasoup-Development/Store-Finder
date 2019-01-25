<?php

namespace Peasoup\Storefinder\Model;


use Magento\Framework\DataObject\IdentityInterface;
use Peasoup\Storefinder\Api\Data\StoresInterface;


class Stores  extends \Magento\Framework\Model\AbstractModel implements  IdentityInterface, StoresInterface {



    const CACHE_TAG = 'STOREFINDER_STORES';


    /**
     * List of attributes in StoresInterface
     * @var array
     */
    protected $interfaceAttributes = [
        StoresInterface::ID,
        StoresInterface::NAME,
        StoresInterface::ADDRESS1,
        StoresInterface::ADDRESS2,
        StoresInterface::TOWN,
        StoresInterface::COUNTRY,
        StoresInterface::POSTCODE,
        StoresInterface::TELEPHONE,
        StoresInterface::EMAIL,
        StoresInterface::MONDAY,
        StoresInterface::TUESDAY,
        StoresInterface::WEDNESDAY,
        StoresInterface::THURSDAY,
        StoresInterface::FRIDAY,
        StoresInterface::SATURDAY,
        StoresInterface::SUNDAY,
        StoresInterface::BANKHOLIDAY,
        StoresInterface::SYNOPSIS,
        StoresInterface::LONGITUDE,
        StoresInterface::LATITUDE,
        StoresInterface::NOTES,
    ];

    /**
    * Define resource model
    */
    protected function _construct() {
        $this->_init('Peasoup\Storefinder\Model\ResourceModel\Stores');
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

    public function saveData($data) {

        if(array_key_exists('store_id',$data['storeinformation'])){
            $this->setId($data['storeinformation']['store_id']);
        }

        $this->setName($data['storeinformation']['name']);
        $this->setSynopsis($data['storeinformation']['synopsis']);
        $this->setNotes($data['storeinformation']['notes']);

        $this->setData("address1",$data['addressdetails']['address1']);
        $this->setData("address2",$data['addressdetails']['address2']);


        $this->setTown($data['addressdetails']['town']);
        $this->setCountry($data['addressdetails']['country']);
        $this->setPostcode($data['addressdetails']['postcode']);

        $this->setTelephone($data['contactdetails']['telephone']);
        $this->setEmail($data['contactdetails']['email']);

        $this->setMonday($data['openinghours']['monday']);
        $this->setTuesday($data['openinghours']['tuesday']);
        $this->setWednesday($data['openinghours']['wednesday']);
        $this->setThursday($data['openinghours']['thursday']);
        $this->setFriday($data['openinghours']['friday']);
        $this->setSaturday($data['openinghours']['saturday']);
        $this->setSunday($data['openinghours']['sunday']);
        $this->setBankHoliday($data['openinghours']['bank_holiday']);




        $this->setLongitude($data['mapsettings']['longitude']);
        $this->setLatitude($data['mapsettings']['latitude']);


        return $this;

    }


    /**
     * @return int|null
     */
    public function getId()
    {
        return $this->_getData(self::ID);
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ID, $id);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->_getData(self::NAME);
    }

    /**
     * @param $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * @return string
     */
    public function getAddress1()
    {
        return $this->_getData(self::ADDRESS1);
    }

    /**
     * @param $address1
     * @return $this
     */
    public function setAddress1($address1)
    {
        return $this->setData(self::ADDRESS1, $address1);
    }

    /**
     * @return string
     */
    public function getAddress2()
    {
        return $this->_getData(self::ADDRESS2);
    }

    /**
     * @param $address2
     * @return $this
     */
    public function setAddress2($address2)
    {
        return $this->setData(self::ADDRESS2, $address2);
    }

    /**
     * @return string
     */
    public function getTown()
    {
        return $this->_getData(self::TOWN);
    }

    /**
     * @param $town
     * @return $this
     */
    public function setTown($town)
    {
        return $this->setData(self::TOWN, $town);
    }

    /**
     * @return string
     */
    public function getCounty()
    {
        // TODO: Implement getCounty() method.
    }

    /**
     * @param $county
     * @return $this
     */
    public function setCounty($county)
    {

    }

    /**
     * @return string
     */
    public function getCountry()
    {
        return $this->_getData(self::COUNTRY);
    }

    /**
     * @param $country
     * @return $this
     */
    public function setCountry($country)
    {
        return $this->setData(self::COUNTRY, $country);
    }

    /**
     * @return string
     */
    public function getPostcode()
    {
        return $this->_getData(self::POSTCODE);
    }

    /**
     * @param $postcode
     * @return $this
     */
    public function setPostcode($postcode)
    {
        return $this->setData(self::POSTCODE, $postcode);
    }

    /**
     * @return string
     */
    public function getTelephone()
    {
        return $this->_getData(self::TELEPHONE);
    }

    /**
     * @param $telephone
     * @return $this
     */
    public function setTelephone($telephone)
    {
        return $this->setData(self::TELEPHONE, $telephone);
    }

    /**
     * @return string
     */
    public function getMonday()
    {
        return $this->_getData(self::MONDAY);
    }

    /**
     * @param $monday
     * @return $this
     */
    public function setMonday($monday)
    {
        return $this->setData(self::MONDAY, $monday);
    }

    /**
     * @return string
     */
    public function getTuesday()
    {
        return $this->_getData(self::TUESDAY);
    }

    /**
     * @param $tuesday
     * @return $this
     */
    public function setTuesday($tuesday)
    {
        return $this->setData(self::TUESDAY, $tuesday);
    }

    /**
     * @return string
     */
    public function getWednesday()
    {
        return $this->_getData(self::WEDNESDAY);
    }

    /**
     * @param $wednesday
     * @return $this
     */
    public function setWednesday($wednesday)
    {
        return $this->setData(self::WEDNESDAY, $wednesday);
    }

    /**
     * @return string
     */
    public function getThursday()
    {
        return $this->_getData(self::THURSDAY);
    }

    /**
     * @param $thursday
     * @return $this
     */
    public function setThursday($thursday)
    {
        return $this->setData(self::THURSDAY, $thursday);
    }

    /**
     * @return string
     */
    public function getFriday()
    {
        return $this->_getData(self::FRIDAY);
    }

    /**
     * @param $friday
     * @return $this
     */
    public function setFriday($friday)
    {
        return $this->setData(self::FRIDAY, $friday);
    }

    /**
     * @return string
     */
    public function getSaturday()
    {
        return $this->_getData(self::SATURDAY);
    }

    /**
     * @param $saturday
     * @return $this
     */
    public function setSaturday($saturday)
    {
        return $this->setData(self::SATURDAY, $saturday);
    }

    /**
     * @return string
     */
    public function getSunday()
    {
        return $this->_getData(self::SUNDAY);
    }

    /**
     * @param $sunday
     * @return $this
     */
    public function setSunday($sunday)
    {
        return $this->setData(self::SUNDAY, $sunday);
    }

    /**
     * @return string
     */
    public function getBankHoliday()
    {
        return $this->_getData(self::BANKHOLIDAY);
    }

    /**
     * @param $bank_holiday
     * @return $this
     */
    public function setBankHoliday($bank_holiday)
    {
        return $this->setData(self::BANKHOLIDAY, $bank_holiday);
    }

    /**
     * @return string
     */
    public function getSynopsis()
    {
        return $this->_getData(self::SYNOPSIS);
    }

    /**
     * @param $synopsis
     * @return $this
     */
    public function setSynopsis($synopsis)
    {
        return $this->setData(self::SYNOPSIS, $synopsis);
    }

    /**
     * @return string
     */
    public function getLongitude()
    {
        return $this->_getData(self::LONGITUDE);
    }

    /**
     * @param $longitude
     * @return $this
     */
    public function setLongitude($longitude)
    {
        return $this->setData(self::LONGITUDE, $longitude);
    }

    /**
     * @return string
     */
    public function getLatitude()
    {
        return $this->_getData(self::LATITUDE);
    }

    /**
     * @param $latitude
     * @return $this
     */
    public function setLatitude($latitude)
    {
        return $this->setData(self::LATITUDE, $latitude);
    }

    /**
     * @return string
     */
    public function getNotes()
    {
        return $this->_getData(self::NOTES);
    }

    /**
     * @param $notes
     * @return $this
     */
    public function setNotes($notes)
    {
        return $this->setData(self::NOTES, $notes);
    }
}