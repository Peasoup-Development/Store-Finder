<?php

namespace Peasoup\Storefinder\Controller\Index;
use Peasoup\Storefinder\Model\StoresFactory;
use Peasoup\Storefinder\Model\StoresRepository;
class Stores extends \Magento\Framework\App\Action\Action
{
    protected $_storesFactory;
    protected $_resultJson;
    protected $_storesRepository;
    protected $_request;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\App\Request\Http $request,
        StoresRepository $storesRepository,
        StoresFactory $storesFactory
    )
    {
        $this->_storesFactory = $storesFactory;
        $this->_resultJson =  $resultJsonFactory;
        $this->_request =  $request;
        $this->_storesRepository = $storesRepository;
        parent::__construct($context);
    }

    public function execute() {

        $id = $this->_request->getParam('id');
        if(isset($id))
        {
            $store = $this->_storesRepository->getById($id);
            $resultJson = $this->_resultJson->create();
            return $resultJson->setData($store);
        }
        else {
            $collection = $this->_storesFactory->create()->getCollection();
            $joinConditions[] = 'main_table.store_id = vdi.store_id';
            $joinConditions[] = "vdi.default_image = '1'";
            $joinConditions = implode(
                ' AND ', $joinConditions
            );
            $collection->getSelect()->joinLeft(
                ['vdi' => $collection->getTable('vapedirect_storefinder_images')],
                $joinConditions,
                [
                    'image' => 'vdi.image'
                ]
            );
            $collection->addFieldToSelect(array('*'));
            $resultJson = $this->_resultJson->create();
            return $resultJson->setData($collection);
        }
    }
}