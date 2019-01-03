<?php

namespace Peasoup\Storefinder\Model;


use Magento\Framework\DataObject\IdentityInterface;


class Stores  extends \Magento\Framework\Model\AbstractModel implements  IdentityInterface {



    const CACHE_TAG = 'STOREFINDER_STORES';


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

    public function saveItem($data) {
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
        $this->setBank($data['openinghours']['bank']);

        $this->setFacebookPageId($data['socialsettings']['facebook_page_id']);
        $this->setFacebookAccessToken($data['socialsettings']['facebook_access_token']);
        $this->setPlaceId($data['socialsettings']['placeId']);


        $this->setLongitude($data['mapsettings']['longitude']);
        $this->setLatitude($data['mapsettings']['latitude']);



        return $this;

    }


}