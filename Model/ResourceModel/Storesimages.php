<?php

namespace Peasoup\Storefinder\Model\ResourceModel;

class Storesimages extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{

    const PEASOUP_STAFF_ENTITY_TYPE = 'peasoup_storefinder_images';

    const PEASOUP_STAFF_FILE_PATH_UPLOADED = 'wysiwyg'.DIRECTORY_SEPARATOR.'storefinder'.DIRECTORY_SEPARATOR.'stores'.DIRECTORY_SEPARATOR;

    const PEASOUP_STAFF_FILE_PATH_ACCESS = 'wysiwyg/storefinder/stores/';


    /**
     * Define main table
     */
    protected function _construct()
    {
        $this->_init('peasoup_storefinder_images', 'image_id');
    }



}