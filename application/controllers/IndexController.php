<?php
class IndexController extends QingPHP_Controller_Abstract
{
	//protected $enableView = true;
	public function init()
	{
		//关闭视图
		$this->enableView(false);
	}
    public function indexAction()
    {
        $this->getResponse()->setBody("Hello World");
        $this->getResponse()->response();
    	/*$blog = blogModel::instance();
    	$list = $blog->getList();*/
    	//$this->view->assign('name', 'chen1706');
    	//$this->view->display('hello.html');    	
    }
}
