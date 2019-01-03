<?php
/**
 * Copyright © 2016 AionNext Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Peasoup\Storefinder\Block\Adminhtml;


/**
 * Adminhtml Aion items content block
 */
class Storefinder extends \Magento\Backend\Block\Widget\Grid\Container
{
    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_blockGroup = 'Peasoup_Storefinder';
        $this->_controller = 'adminhtml_stores';
        $this->_headerText = __('Items');
        $this->_addButtonLabel = __('Create Store');
        parent::_construct();
    }
}