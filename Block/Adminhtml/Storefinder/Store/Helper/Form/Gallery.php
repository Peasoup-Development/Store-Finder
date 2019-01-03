<?php
namespace Peasoup\Storefinder\Block\Adminhtml\Storefinder\Store\Helper\Form;



class Gallery extends \Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery
{

    /**
     * @var here you set your ui form
     */
    protected $formName = 'storefinder_storefinder_form';

    /**
     * Return Tab label
     *
     * @return string
     * @api
     */
    public function getTabLabel()
    {
        return 'Image Gallery';
    }

    /**
     * Return Tab title
     *
     * @return string
     * @api
     */
    public function getTabTitle()
    {
        return 'Image Gallery';
    }

    /**
     * Can show tab in tabs
     *
     * @return boolean
     * @api
     */
    public function canShowTab()
    {
       return true;
    }

    /**
     * Tab is hidden
     *
     * @return boolean
     * @api
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Tab should be loaded trough Ajax call
     *
     * @return bool
     */
    public function isAjaxLoaded()
    {
        return false;
    }
}
