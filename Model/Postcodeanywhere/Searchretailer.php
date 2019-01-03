<?php

namespace Peasoup\Storefinder\Model\Postcodeanywhere;


class Searchretailer extends \Magento\Framework\Model\AbstractModel {



    private $Key = 'UH35-XP39-MD25-HU64'; //The key to use to authenticate to the service.
    private $Origin; //The origin for the search. This should be an Id from FindPlaceNames, a UK postcode, UK easting + northing or Latitude, Longitude.
    private $MaximumItems; //The maximum number of items to return. If 0, all items are returned. For FastestByRoad queries, a maximum of 100 is enforced.
    private $MaximumRadius; //The maximum search distance in KM between the origin and a store. If blank or 0, all items are returned.
    private $MaximumTime; //The maximum drive time in minutes between the origin and a store. Ignored for StraightLine DistanceType. If blank or 0, all items are returned.
    private $DistanceType; //Specifies how the distances between the stores are calculated.
    private $LocationLists; //The names or IDs of the location lists containing the stores to use. Alternatively, a list of UK postcodes for the locations. If blank, the default location list for this key will be used. Use the Management/LocationList/List service to get information on location lists.
    private $Data; //Holds the results of the query


    protected function _construct() {
        $this->_init('Peasoup\Storefinder\Model\ResourceModel\Stores');
    }

    public function setFinderData($Key, $Origin, $MaximumItems, $MaximumRadius, $MaximumTime, $DistanceType, $LocationLists) {
        $this->Key = $Key;
        $this->Origin = $Origin;
        $this->MaximumItems = $MaximumItems;
        $this->MaximumRadius = $MaximumRadius;
        $this->MaximumTime = $MaximumTime;
        $this->DistanceType = $DistanceType;
        $this->LocationLists = $LocationLists;
    }

    public function makeSearchRequest() {
        $url = "http://services.postcodeanywhere.co.uk/StoreFinder/Interactive/RetrieveNearest/v1.20/json.ws?";
        $url .= "&Key=" . urlencode($this->Key);
        $url .= "&Origin=" . urlencode($this->Origin);
        $url .= "&MaximumItems=" . urlencode($this->MaximumItems);
        $url .= "&MaximumRadius=" . urlencode($this->MaximumRadius);
        $url .= "&MaximumTime=" . urlencode($this->MaximumTime);
        $url .= "&DistanceType=" . urlencode($this->DistanceType);
        $url .= "&LocationLists=" . urlencode($this->LocationLists);

        //Make the request to Postcode Anywhere and parse the XML returned
        $json = json_decode(file_get_contents( $url), true);

       //  $json = array(0=>array('YourId'=>1,"Name"=>"Vapedirect Shop","Description"=>"","Distance"=>135.98,"Time"=>108.45,"Easting"=> 482351,"Northing"=> 239912,"Latitude"=>52.0514,"Longitude"=> -0.8005));


        //Copy the data
        if ( count($json) > 0 )
        {
            foreach ($json as $item)
            {
                $this->Data[] = array('entity_id'=>$item['YourId'],'Name'=>$item['Name'],'Description'=>$item['Description'],'Distance'=>$item['Distance'],'Time'=>$item['Time'],
                    'Easting'=>$item['Easting'],'Northing'=>$item['Northing'],'Latitude'=>$item['Latitude'],'Longitude'=>$item['Longitude']);
            }
        }
        else {

        }
    }

    public function HasDataReturned()
    {
        if ( !empty($this->Data) )
        {
            return $this->Data;
        }
        return false;
    }

}