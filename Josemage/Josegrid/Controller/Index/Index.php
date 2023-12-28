<?php
namespace Josemage\Josegrid\Controller\Index;

use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\View\Result\PageFactory;


/**
 * Class Index
 */
class Index  implements HttpGetActionInterface
{
    /**
     * @var PageFactory
     */
    private $pageFactory;


    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @param PageFactory $pageFactory
     * @param RequestInterface $request
     */
    public function __construct(PageFactory $pageFactory, RequestInterface $request)
    {
        $this->pageFactory = $pageFactory;
        $this->request = $request;
    }

    /**
     * @return void
     */
    public function execute()
    {
        echo 'Execute Action Index_Index OK';
        $this->pageFactory->create();
        die();
    }
}
