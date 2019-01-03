<?php
namespace Peasoup\Storefinder\Block\Adminhtml\Storefinder\Store\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Peasoup\Staff\Block\Adminhtml\Newreviews\Edit\GenericButton;
/**
 * Class SaveButton
 */
class SaveButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Save Store'),
            'class' => 'save primary',
            'data_attribute' => [
                'mage-init' => ['button' => ['event' => 'save']],
                'form-role' => 'save',
            ],
            'sort_order' => 90,
        ];
    }



}