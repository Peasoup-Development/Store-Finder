<?php

namespace Peasoup\Storefinder\Block;

use Peasoup\Storefinder\Model\StoresFactory;

class Storefinder extends \Magento\Framework\View\Element\Template
{
    protected $_storesFactory;
    protected $_storesCollection;
    protected $_pageConfig;
    private $_storesManager;
    /**
     * @var \Peasoup\Storefinder\Helper\Data
     */
    private $helper;


    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\View\Page\Config $pageConfig,
        \Peasoup\Storefinder\Helper\Data $helper,
        StoresFactory $storesFactory,

        array $data = []
    ) {

        $this->_storesFactory = $storesFactory;
        parent::__construct($context, $data);
        $this->_pageConfig = $pageConfig;
        $this->_storesManager = $context->getStoreManager();
        $this->helper = $helper;
    }

    public function _prepareLayout()
    {
        $pageTitle = $this->getPageTitle();
        if(empty($this->_pageConfig->getTitle()->get())) {
            $this->_pageConfig->getTitle()->set(__($pageTitle));
        }

        $collection = $this->_storesFactory->create();
        $this->_storesCollection = $collection;
    }

    public function getStoresCollection()
    {
        return $this->_storesCollection;
    }

    public function getMediaPath()
    {
        return $this->_storesManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA)."storefinder/store/";
    }

    public function getApiKey()
    {
        if($this->helper->getConfig('storefindersettings/general/active')):
            return $this->helper->getConfig('storefindersettings/mapsettings/apikey');
        endif;
    }

    public function getIntroductionTitle()
    {
        if($this->helper->getConfig('storefindersettings/general/active')):
            return $this->helper->getConfig('storefindersettings/general/storefinderintroductiontitle');
        endif;
    }

    public function getIntroduction()
    {
        if($this->helper->getConfig('storefindersettings/general/active')):
            return $this->helper->getConfig('storefindersettings/general/storefinderintroduction');
        endif;
    }

    public function getPageTitle()
    {
        if($this->helper->getConfig('storefindersettings/general/active')):
            return $this->helper->getConfig('storefindersettings/seosettings/storefinderpagetitle');
        endif;
    }
}