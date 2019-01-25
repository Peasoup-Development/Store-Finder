<?php

namespace Peasoup\Storefinder\Block\Adminhtml\Storefinder\Store\Edit\Form;

class Map extends \Magento\Framework\View\Element\Template {



    /**
     *  constructor.
     *
     * @param \Magento\Backend\Block\Template\Context  $context
     * @param array                                    $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
}
