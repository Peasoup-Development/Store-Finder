<?php
namespace Peasoup\Storefinder\Model\Stores;
use Peasoup\Storefinder\Model\ResourceModel\Stores\CollectionFactory;
class DataProvider extends \Magento\Ui\DataProvider\AbstractDataProvider
{
    /**
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $contactCollectionFactory
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $contactCollectionFactory,
        array $meta = [],
        array $data = []
    ) {


        $this->collection = $contactCollectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }


    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }
        $items = $this->collection->getItems();
        $this->loadedData = array();
        /** @var Customer $customer */
        foreach ($items as $contact) {
            foreach($this->getFieldsMap() as $group=>$data){
                foreach($data as $junk=>$fieldName){
                    $this->loadedData[$contact->getId()][$group][$fieldName] = $contact->getData($fieldName);
                }
            }
            $this->loadedData[$contact->getId()]['stores'] = $contact->getData();
        }
        return $this->loadedData;
    }

    protected function getFieldsMap()
    {
        return [
            'storeinformation' => [
                'store_id',
                'name',
                'synopsis',
                'notes',
            ],
            'addressdetails' => [
                'address1',
                'address2',
                'town',
                'country',
                'postcode',
            ],
            'contactdetails' => [
                'email',
                'telephone',
            ],
            'openinghours' => [
                'monday',
                'tuesday',
                'wednesday',
                'thursday',
                'friday',
                'saturday',
                'sunday',
                'bank',
            ],
            'socialsettings' => [
                'facebook_page_id',
                'facebook_access_token',
                'placeId',
            ],
            'mapsettings' => [
                'longitude',
                'latitude',
            ],
        ];
    }



}