<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

namespace Peasoup\Storefinder\Model\Product\Media;



class Config extends \Magento\Catalog\Model\Product\Media\Config
{
    /**
     * @return string
     */
    public function getBaseMediaUrl()
    {
        return $this->storeManager->getStore()->getBaseUrl(\Magento\Framework\UrlInterface::URL_TYPE_MEDIA) .$this->getBaseMediaUrlAddition();
    }
    /**
     * Filesystem directory path of product images
     * relatively to media folder
     *
     * @return string
     */
    public function getBaseMediaPathAddition()
    {
        return 'wysiwyg/storefinder/stores';
    }

    /**
     * Web-based directory path of product images
     * relatively to media folder
     *
     * @return string
     */
    public function getBaseMediaUrlAddition()
    {
        return 'wysiwyg/storefinder/stores';
    }

    /**
     * @return string
     */
    public function getBaseMediaPath()
    {
        return 'wysiwyg/storefinder/stores';
    }
}
