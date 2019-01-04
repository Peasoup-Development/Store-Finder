<?php
namespace Peasoup\Storefinder\Block\Adminhtml\Storefinder\Store\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Peasoup\Storefinder\Block\Adminhtml\Storefinder\Store\GenericButton;
/**
 * Class BackButton
 */
class ResetButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30
        ];
    }
}