<?php

namespace Peasoup\Storefinder\Block\Index;



class Storecontent extends \Magento\Framework\View\Element\Template
{
    private $_storesManager;
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        array $data = []
    ) {
        $this->_storesManager = $context->getStoreManager();
        parent::__construct($context, $data);
    }


    public function getMediaPath(){
        return $this->_storesManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }


}