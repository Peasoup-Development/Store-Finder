<?php

namespace Peasoup\Storefinder\Block\Storefinder;

use Peasoup\Storefinder\Model\StoresRepository;
use Peasoup\Storefinder\Model\StoresimagesFactory;

class View extends \Magento\Framework\View\Element\Template
{
    protected $_storesRepository;
    protected $_registry;
    protected $_storesimagesFactory;
    protected $_store;
    protected $_images;

    public $_storesmanager;
    private $_fbFeed;
    protected $_gFeed;
    private $_fbTestimonials;
    private $_ggTestimonials;
    public $limit = 50;
    /**
     * @var \Peasoup\Socialfeed\Model\ResourceModel\Testimonial\CollectionFactory
     */
    private $collectionFactory;
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
        \Peasoup\Socialfeed\Model\ResourceModel\Testimonial\CollectionFactory $collectionFactory,
        StoresimagesFactory $storesimagesFactory,
        array $data = []
    ) {
        $this->_storesRepository = $storesRepository;
        $this->_storesimagesFactory = $storesimagesFactory;

        $this->_request = $request;
        $this->_storesManager = $context->getStoreManager();
        parent::__construct($context, $data);
        $this->collectionFactory = $collectionFactory;
        $this->_pageConfig = $pageConfig;
    }

    public function _prepareLayout()
    {
        $this->store_id = $this->_request->getParam('id');

        $this->_store = $this->_storesRepository->getById(  $this->store_id);

        $this->_pageConfig->getTitle()->set(__(($this->_store->getName()." Vape Shop in ".$this->_store->getTown()." | Vape Direct"))); // add title here
        $this->_pageConfig->setDescription( $this->_store->getSynopsis());



        $this->_images = $this->_storesimagesFactory->create()->getCollection()
                ->addFieldToFilter(
        'store_id',
        ['eq' => $this->_request->getParam('id')]
    )->setOrder('default_image','DESC');

    }

    public function getStore(){
        return $this->_store;
    }

    public function getTestimonials() {
        $collection = $this->collectionFactory->create();
        $collection->addFilter('store_id' , array('eq'=> $this->store_id));

        $joinConditions[] = 'main_table.platform_id = vsp.platform_id';


        $joinConditions = implode(
            ' AND ', $joinConditions
        );

        $collection->getSelect()->joinLeft(
            [
                'vsp' => $collection->getTable('vapedirect_social_platform')
            ],
            $joinConditions,
            [
                'platform' => 'vsp.platform'
            ]
        );
        $collection->setOrder('created_at','DESC');
        $collection->getSelect()->limit(30);
        return $collection;
    }

    public function fixRating($rating){
        switch ($rating) {
            case "ONE":
                return 1;
                break;
            case "TWO":
                return 2;
                break;
            case "THREE":
                return 3;
                break;
            case "FOUR":
                return 4;
                break;
            case "FIVE":
                return 5;
                break;
        }
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