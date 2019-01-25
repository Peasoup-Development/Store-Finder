<?php

namespace Peasoup\Storefinder\Block\Storefinder;

use Peasoup\Storefinder\Model\StoresRepository;
use Peasoup\Storefinder\Model\StoresImagesFactory;

class View extends \Magento\Framework\View\Element\Template
{
    protected $_storesRepository;
    protected $_registry;
    protected $_storesimagesFactory;
    protected $_store;
    protected $_images;

    public $_storesmanager;
    protected $_gFeed;
    public $limit = 50;

    private $store_id;
    protected $_pageConfig;
    /**
     * View constructor.
     * @param \Magento\Framework\View\Element\Template\Context $context
     * @param StoresRepository $storesRepository
     * @param \Magento\Framework\App\Request\Http $request
     * @param \Peasoup\Socialfeed\Model\Facebookfeed $fbFeed
     * @param StoresimagesFactory $storesimagesFactory
     * @param array $data
     */
    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        StoresRepository $storesRepository,
        \Magento\Framework\View\Page\Config $pageConfig,
        \Magento\Framework\App\Request\Http $request,
        StoresimagesFactory $storesimagesFactory,
        array $data = []
    ) {
        $this->_storesRepository = $storesRepository;
        $this->_storesimagesFactory = $storesimagesFactory;

        $this->_request = $request;
        $this->_storesManager = $context->getStoreManager();
        parent::__construct($context, $data);
        $this->_pageConfig = $pageConfig;
    }

    public function _prepareLayout()
    {

        $this->store_id = $this->_request->getParam('id');

        $this->_store = $this->_storesRepository->getById(  $this->store_id);

      //  $this->_pageConfig->getTitle()->set(__(($this->_store->getName()." Vape Shop in ".$this->_store->getTown()." | Vape Direct"))); // add title here
      //  $this->_pageConfig->setDescription( $this->_store->getSynopsis());



        $this->_images = $this->_storesimagesFactory->create()->getCollection()
                ->addFieldToFilter(
        'store_id',
        ['eq' => $this->_request->getParam('id')]
    )->setOrder('default_image','DESC');



    }

    public function getStore(){
        return $this->_store;
    }

    public function getStoreImages(){
        return $this->_images;
    }

    public function getSynopsis(){
        return $this->_store->getSynopsis();
    }

    public function getMediaPath(){
      return $this->_storesManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA);
    }
}