<?php
namespace Peasoup\Storefinder\Block\Adminhtml\Storefinder\Store\Buttons;

use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use Peasoup\Storefinder\Block\Adminhtml\Storefinder\Store\GenericButton;
/**
 * Class BackButton
 */
class DeleteButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        $data = [];
        if ($this->getId()) {
            $data = [
                'label' => __('Delete'),
                'class' => 'delete',
                'on_click' => 'deleteConfirm(\''
                    . __('Are you sure you want to delete this contact ?')
                    . '\', \'' . $this->getDeleteUrl() . '\')',
                'sort_order' => 20,
            ];
        }
        return $data;
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['review_id' => $this->getId()]);
    }
}