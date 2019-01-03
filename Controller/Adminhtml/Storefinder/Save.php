<?php
/**
 * Copyright © 2016 AionNext Ltd. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Peasoup\Storefinder\Controller\Adminhtml\Storefinder;

use Peasoup\Storefinder\Model\StoresFactory;
use Peasoup\Storefinder\Model\ResourceModel\Storesimages;
use Peasoup\Storefinder\Model\StoresImagesFactory;
use Magento\Framework\App\Filesystem\DirectoryList;

ini_set('display_errors',1);
class Save extends \Peasoup\Storefinder\Controller\Adminhtml\Storefinder
{
    /**
     * @var \Magento\Framework\View\Result\PageFactory
     */
    private $resultPageFactory;
    /**
     * @var StoresFactory
     */
    private $storesFactory;
    /**
     * @var StoresImagesFactory
     */
    private $storesImagesFactory;
    /**
     * @var \Magento\Framework\App\Filesystem\DirectoryList
     */
    private $directoryList;
    /**
     * @var \Magento\MediaStorage\Model\File\UploaderFactory
     */
    private $fileUploaderFactory;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     * @param \Magento\Backend\Model\View\Result\ForwardFactory $resultForwardFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Framework\Registry $coreRegistry,
        StoresFactory $storesFactory,
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\MediaStorage\Model\File\UploaderFactory $fileUploaderFactory,
        StoresImagesFactory $storesImagesFactory,
        \Magento\Framework\View\Result\PageFactory $resultPageFactory
    ) {
        parent::__construct($context, $coreRegistry);
        $this->resultPageFactory = $resultPageFactory;
        $this->storesFactory = $storesFactory;
        $this->storesImagesFactory = $storesImagesFactory;
        $this->directoryList = $directoryList;
        $this->fileUploaderFactory = $fileUploaderFactory;
    }

    /**
     * Create new item
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();


        if ($data) {
            $model = $this->storesFactory->create();

            $id = false;

            if(isset($data['storeinformation']['store_id'])){
                $id = $data['storeinformation']['store_id'];

            }

            $model = $model->load($id);
            if (!$model->getId() && $id) {

                 $this->messageManager->addErrorMessage(__('UHOH somehting went wrong'));
             //   return $resultRedirect->setPath('*/*/');
            }

            try {

                $model->saveItem($data)->save();

                $this->messageManager->addSuccessMessage(__('You saved the Store'));

                if ($this->getRequest()->getParam('back')) {

                    return $resultRedirect->setPath('*/*/edit', ['faq_id' => $this->model->getStaffId()]);
                }
          //      return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e, __('Something went wrong while saving the Review.'));
                $this->messageManager->addErrorMessage($e->getMessage());
            }
           if(isset($data['product'])){
            $mediaGallery = $data['product'];


            foreach($mediaGallery as $gallery){
                foreach($gallery['images'] as $image){

                    if($image['file']!=""){
                        $imagesFactory = $this->storesImagesFactory->create();
                        $imagesFactory->setImage(str_replace(".tmp","",$image['file']));
                        if($image['position']==0){
                            $imagesFactory->setDefaultImage(1);
                        }
                        else {
                            $imagesFactory->setDefaultImage(0);
                        }
                        $imagesFactory->setStoreId($model->getId());
                  //      $imagesFactory->save();


                        try {


                            $faq_path_upload = $this->directoryList->getRoot().DIRECTORY_SEPARATOR.DirectoryList::PUB.DIRECTORY_SEPARATOR.DirectoryList::MEDIA.DIRECTORY_SEPARATOR;



                            $uploader = $this->fileUploaderFactory->create(['fileId' => 'image']);

                            $uploader->setAllowedExtensions(['jpg', 'jpeg', 'gif', 'png']);

                            $uploader->setAllowRenameFiles(true);

                            $image = $uploader->save($faq_path_upload.Storesimages::PEASOUP_STAFF_FILE_PATH_UPLOADED);

                            if (!empty($image['file'])) {
                                $image_old = !empty($image['file']) ? $image['file'] : 'search-image-file.jpg';
                                $data['image'] = Storesimages::PEASOUP_STAFF_FILE_PATH_ACCESS.$image['file'];
                                try {

                                    if (file_exists($faq_path_upload.$image_old)) {
                                        unlink($faq_path_upload.$image_old);
                                    }
                                } catch (\Exception $e) {
                                    $this->messageManager->addError($e->getMessage());
                                }
                            }
                        } catch (\Exception $e) {
                            if ($e->getCode() != \Magento\Framework\File\Uploader::TMP_NAME_EMPTY) {
                                $this->messageManager->addErrorMessage(__('Can not save the Category icon: '.$e->getMessage()));

                            }
                        }






















                    }

                }


            }




           }

            return $resultRedirect->setPath('*/*/index');
        }


    }



}