<?php

namespace Peasoup\Storefinder\Block\Adminhtml\Storefinder\Store\Helper\Form\Gallery;

use Peasoup\Storefinder\Model\StoresimagesFactory;

use Magento\Backend\Block\Media\Uploader;
use Magento\Framework\View\Element\AbstractBlock;
use Magento\Framework\App\Filesystem\DirectoryList;
use Magento\Framework\Exception\FileSystemException;
use Peasoup\Storefinder\Model\Product\Media\Config;

class Content extends \Magento\Catalog\Block\Adminhtml\Product\Helper\Form\Gallery\Content
{
    protected $_template = 'storefinder/store/helper/gallery.phtml';
    /**
     * @var StoresimagesFactory
     */
    private $storesimagesFactory;
    /**
     * @var Config
     */
    private $productMedia;


    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Json\EncoderInterface $jsonEncoder
     * @param \Magento\Catalog\Model\Product\Media\Config $mediaConfig
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Json\EncoderInterface $jsonEncoder,
        \Magento\Catalog\Model\Product\Media\Config $mediaConfig,
        array $data = [],
        StoresimagesFactory $storesimagesFactory,
        \Magento\Framework\Filesystem $filesystem,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
         Config $productMedia
    ) {

        $this->storesimagesFactory = $storesimagesFactory;
        $this->_filesystem = $filesystem;
        $this->_fileUploaderFactory = $fileUploaderFactory;
        parent::__construct($context,$jsonEncoder,$mediaConfig,$data);
        $this->productMedia = $productMedia;
    }



    protected function _prepareLayout()
    {
        $this->addChild('uploader', 'Magento\Backend\Block\Media\Uploader');

        $a = $this->getUploader()->getConfig()->setUrl(
            $this->_urlBuilder->addSessionParam()->getUrl('*/*/upload')/* here set you upload Controller */
        )->setFileField(
            'image'
        )->setFilters(
            [
                'images' => [
                    'label' => __('Images (.gif, .jpg, .png)'),
                    'files' => ['*.gif', '*.jpg', '*.jpeg', '*.png'],
                ],
            ]
        );

    }











    /**
     * @return string
     */
    public function getImagesJson()
    {


        $images = $this->storesimagesFactory->create()->getCollection()
            ->addFieldToFilter(
                'store_id',
                ['eq' =>  $this->getRequest()->getParam('id')]
            )->setOrder('default_image','DESC')->getData();


        if (is_array($images)
        ) {

            $mediaDir = $this->_filesystem->getDirectoryRead(DirectoryList::MEDIA);
    //        $images = $this->sortImagesByPosition($value['images']);


            foreach ($images as $image) {
                $image['url'] = $this->productMedia->getMediaUrl($image['image']);
                $image['media_type'] = 'image';
                $image['value_id'] = $image['image_id'];

                try {
                    $fileHandler = $mediaDir->stat($this->productMedia->getMediaPath($image['image']));

                    $image['size'] = $fileHandler['size'];
                } catch (FileSystemException $e) {
                    $image['url'] = $this->getImageHelper()->getDefaultPlaceholderUrl('small_image');
                    $image['size'] = 0;
                    $this->_logger->warning($e);
                }

                $imgArray[] = $image;
            }

            return $this->_jsonEncoder->encode($imgArray);
        }
        return [];
    }


    public function getImageTypes()
    {

        return [];
    }

    public function getMediaAttributes()
    {
        return [];
    }

}
