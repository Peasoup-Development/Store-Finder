<?php

namespace Peasoup\Storefinder\Api\Data;

interface StoresInterface
{

    /**#@+
     * Constants defined for keys of  data array
     */
    const ID = 'store_id';
    const NAME = 'name';
    const ADDRESS1 = 'address1';
    const ADDRESS2 = 'address2';
    const TOWN = 'town';
    const COUNTRY = 'country';
    const POSTCODE = 'postcode';
    const TELEPHONE = 'telephone';
    const EMAIL = 'email';
    const MONDAY = 'monday';
    const TUESDAY = 'tuesday';
    const WEDNESDAY = 'wednesday';
    const THURSDAY = 'thursday';
    const FRIDAY = 'friday';
    const SATURDAY = 'saturday';
    const SUNDAY = 'sunday';
    const BANKHOLIDAY = 'bank_holiday';
    const SYNOPSIS = 'synopsis';
    const LONGITUDE = 'longitude';
    const LATITUDE = 'latitude';
    const NOTES = 'notes';



    /**
     * @return int|null
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
    public function getName();


    /**
     * @param $name
     * @return $this
     */
    public function setName($name);


    /**
     * @return string
     */
    public function getAddress1();


    /**
     * @param $address1
     * @return $this
     */
    public function setAddress1($address1);


    /**
     * @return string
     */
    public function getAddress2();


    /**
     * @param $address2
     * @return $this
     */
    public function setAddress2($address2);

    /**
     * @return string
     */
    public function getTown();


    /**
     * @param $town
     * @return $this
     */
    public function setTown($town);


    /**
     * @return string
     */
    public function getCounty();


    /**
     * @param $county
     * @return $this
     */
    public function setCounty($county);


    /**
     * @return string
     */
    public function getCountry();


    /**
     * @param $country
     * @return $this
     */
    public function setCountry($country);

    /**
     * @return string
     */
    public function getPostcode();


    /**
     * @param $postcode
     * @return $this
     */
    public function setPostcode($postcode);

    /**
     * @return string
     */
    public function getTelephone();


    /**
     * @param $telephone
     * @return $this
     */
    public function setTelephone($telephone);

    /**
     * @return string
     */
    public function getMonday();


    /**
     * @param $monday
     * @return $this
     */
    public function setMonday($monday);

    /**
     * @return string
     */
    public function getTuesday();


    /**
     * @param $monday
     * @return $this
     */
    public function setTuesday($tuesday);


    /**
     * @return string
     */
    public function getWednesday();


    /**
     * @param $wednesday
     * @return $this
     */
    public function setWednesday($wednesday);


    /**
     * @return string
     */
    public function getThursday();


    /**
     * @param $thursday
     * @return $this
     */
    public function setThursday($thursday);


    /**
     * @return string
     */
    public function getFriday();


    /**
     * @param $friday
     * @return $this
     */
    public function setFriday($friday);

    /**
     * @return string
     */
    public function getSaturday();


    /**
     * @param $saturday
     * @return $this
     */
    public function setSaturday($saturday);

    /**
     * @return string
     */
    public function getSunday();


    /**
     * @param $sunday
     * @return $this
     */
    public function setSunday($sunday);

    /**
     * @return string
     */
    public function getBankHoliday();


    /**
     * @param $bank_holiday
     * @return $this
     */
    public function setBankHoliday($bank_holiday);


    /**
     * @return string
     */
    public function getSynopsis();


    /**
     * @param $synopsis
     * @return $this
     */
    public function setSynopsis($synopsis);

    /**
     * @return string
     */
    public function getLongitude();


    /**
     * @param $longitude
     * @return $this
     */
    public function setLongitude($longitude);


    /**
     * @return string
     */
    public function getLatitude();


    /**
     * @param $latitude
     * @return $this
     */
    public function setLatitude($latitude);


    /**
     * @return string
     */
    public function getNotes();


    /**
     * @param $notes
     * @return $this
     */
    public function setNotes($notes);

}