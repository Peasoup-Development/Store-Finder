<?php

namespace Peasoup\Storefinder\Block;

use Peasoup\Storefinder\Model\StoresFactory;

class Storelist extends \Magento\Framework\View\Element\Template
{
    protected $_storesFactory;
    protected $_storesCollection;
    private $_storesManager;

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        StoresFactory $storesFactory,
        array $data = []
    ) {
        $this->_storesManager = $context->getStoreManager();
        $this->_storesFactory = $storesFactory;
        parent::__construct($context, $data);

    }

    public function _prepareLayout()
    {
        $post = $this->_storesFactory->create();
        $this->_storesCollection = $post->getCollection();
    }

    public function getStoresCollection(){
        return $this->_storesCollection;

    }

    public function getMediaPath(){
        return $this->_storesManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
    
    
}