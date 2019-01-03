<?php

namespace Peasoup\Storefinder\Controller\Index;
use Peasoup\Storefinder\Model\StoresFactory;
use Peasoup\Storefinder\Model\StoresimagesFactory;

class StoreContent extends \Magento\Framework\App\Action\Action
{
    protected $_storesFactory;
    protected $_resultJson;
    protected $_request;
    protected $_layout;

    public function __construct(
        \Magento\Framework\App\Action\Context $context,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory,
        \Magento\Framework\App\Request\Http $request,
        \Magento\Framework\View\LayoutInterface $layout,
        StoresimagesFactory $storesimagesFactory,
        StoresFactory $storesFactory
    )
    {
        $this->_storesimagesFactory = $storesimagesFactory;
        $this->_storesFactory = $storesFactory;
        $this->_resultJson =  $resultJsonFactory;
        $this->_layout  = $layout;
        $this->_request =  $request;
        parent::__construct($context);
    }

    public function execute() {

        $post = $this->_request->getPost();


        $images = $this->_storesimagesFactory->create()->getCollection()
            ->addFieldToFilter(
                'store_id',
                ['eq' =>$post['data']['store_id']]
            ) ->addFieldToFilter(
                'default_image',
                ['eq' => 1]
            );

        $block = $this->_layout
            ->createBlock(
                "Peasoup\Storefinder\Block\Index\Storecontent",
                "storecontent",
                [
                    'data' => [
                        'store' => $post,
                        'image'=>$images
                    ]
                ]
            )
            ->setData('area', 'frontend')
            ->setTemplate("Peasoup_Storefinder::index/ajax/content.phtml")
            ->toHtml();

        $resultJson = $this->_resultJson->create();
        return $resultJson->setData($block);
    }
}