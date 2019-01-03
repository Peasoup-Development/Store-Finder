<?php

namespace Peasoup\Storefinder\Block;

use Peasoup\Storefinder\Model\StoresFactory;

class Storefinder extends \Magento\Framework\View\Element\Template
{
    protected $_storesFactory;
    protected $_storesCollection;
    protected $_pageConfig;
    private $_storesManager;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\View\Page\Config $pageConfig,
        StoresFactory $storesFactory,

        array $data = []
    ) {

        $this->_storesFactory = $storesFactory;
        parent::__construct($context, $data);
        $this->_pageConfig = $pageConfig;
        $this->_storesManager = $context->getStoreManager();
    }

    public function _prepareLayout()
    {
        if(empty($this->_pageConfig->getTitle()->get())) {
            $this->_pageConfig->getTitle()->set(__('Find a vape shop near me | Vape Direct'));
        }
        $collection = $this->_storesFactory->create();
        $this->_storesCollection = $collection;
    }

    public function getStoresCollection()
    {
        return $this->_storesCollection;
    }
    public function getMediaPath(){
        return $this->_storesManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."wysiwyg/storefinder/stores/";
    }
}