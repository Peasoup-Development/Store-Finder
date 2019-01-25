<?php

namespace Peasoup\Storefinder\Controller\View;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    protected $_resultPageFactory;
    protected $_request;
    protected $_registry;
    protected $_store_id;

    public function __construct(
                                    Context $context,
                                    \Magento\Framework\App\Request\Http $request,
                                    \Magento\Framework\View\Result\PageFactory $resultPageFactory
                               )
    {
        $this->_request = $request;
        $this->_resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }


    public function execute()
    {


        $resultPage = $this->_resultPageFactory->create();
        $this->_store_id = $this->_request->getParam('id');



        // Add breadcrumb
        /** @var \Magento\Theme\Block\Html\Breadcrumbs */
        $breadcrumbs = $resultPage ->getLayout()->getBlock('breadcrumbs');

        $breadcrumbs->addCrumb('home', [
                'label' => __('Home'),
                'title' => __('Back'),
                'link' => $this->_url->getUrl('/')
            ]


        );
        $breadcrumbs->addCrumb('storefinder', [
                'label' => __('Storefinder'),
                'title' => __('Storefinder'),
                'link' => $this->_url->getUrl('/storefinder')
            ]


        );


        return $resultPage;
    }

}