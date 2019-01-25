<?php
namespace Peasoup\Storefinder\Controller\Adminhtml\Storefinder;


use Magento\Backend\App\Action;
use Magento\Framework\App\Filesystem\DirectoryList;

class Upload extends \Magento\Backend\App\Action
{
    /**
     * Image uploader
     *
     * @var \Magento\Catalog\Model\ImageUploader
     */
    protected $imageUploader;
    /**
     * @var \Magento\Framework\Controller\Result\JsonFactory
     */
    private $resultJsonFactory;

    /**
     * Upload constructor.
     *
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Catalog\Model\ImageUploader $imageUploader
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Peasoup\Storefinder\Model\ImageUploader $imageUploader,
        \Magento\Framework\Controller\Result\JsonFactory $resultJsonFactory
    ) {
        parent::__construct($context);
        $this->imageUploader = $imageUploader;
        $this->resultJsonFactory = $resultJsonFactory;
    }

    /**
     * Check admin permissions for this controller
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return true;
       return $this->_authorization->isAllowed('Peasoup_Stoefinder::storefinder');
    }

    /**
     * Upload file controller action
     *
     * @return \Magento\Framework\Controller\ResultInterface
     */
    public function execute()
    {
        $imageId = $this->_request->getParam('param_name', 'image');
        try {
            $result = $this->imageUploader->saveFileToTmpDir($imageId);

            $result['cookie'] = [
                'name' => $this->_getSession()->getName(),
                'value' => $this->_getSession()->getSessionId(),
                'lifetime' => $this->_getSession()->getCookieLifetime(),
                'path' => $this->_getSession()->getCookiePath(),
                'domain' => $this->_getSession()->getCookieDomain(),
            ];
        } catch (\Exception $e) {
            $result = ['error' => $e->getMessage(), 'errorcode' => $e->getCode()];
        }
        $resultJson = $this->resultJsonFactory->create();
        return $resultJson->setData($result);
   //     return $this->resultFactory->create(ResultFactory::TYPE_JSON)->setData($result);
    }
}