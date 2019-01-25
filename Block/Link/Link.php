<?php
/**
 *  * @author Robert Mark Williamson <robert@peasoup-development.com>
 *  * @company Peasoup Development Limited
 *
 */
namespace Peasoup\Storefinder\Block\Link;


use \Magento\Customer\Block\Account\SortLinkInterface;


class Link extends \Magento\Framework\View\Element\Html\Link implements SortLinkInterface
{


    private $helper;

    private $defaultLabel = 'Find a store';

    private $defaultLink = '/storefinder';

    public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Framework\View\Page\Config $pageConfig,
        \Peasoup\Storefinder\Helper\Data $helper,
        array $data = []
    ) {

        $this->_pageConfig = $pageConfig;
        $this->helper = $helper;
        parent::__construct($context, $data);
    }


    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->hasCustomLinkText();
    }
    /**
     * @return string
     */
    public function getLink()
    {
        return $this->hasCustomLink();
    }



    /**
     * Has custom link
     *
     * @return string
     */
    public function hasCustomLink()
    {
        if ($this->helper->getConfig('storefindersettings/general/active')):
            if($this->helper->getConfig('storefindersettings/general/storefinderheadinganchor') !=""){
                return  $this->helper->getConfig('storefindersettings/general/storefinderheadinganchor');
            }
            else {
                return $this->defaultLink;
            }
        endif;
    }



    /**
     * Has custom link Text
     *
     * @return string
     */
    public function hasCustomLinkText()
    {
        if ($this->helper->getConfig('storefindersettings/general/active')):
            if($this->helper->getConfig('storefindersettings/general/storefinderheadinglink') !=""){
              return  $this->helper->getConfig('storefindersettings/general/storefinderheadinglink');
            }
            else {
                return $this->defaultLabel;
            }
        endif;
    }


    /**
     * {@inheritdoc}
     * @since 101.0.0
     */
    public function getSortOrder()
    {
        return $this->getData(self::SORT_ORDER);
    }
}
