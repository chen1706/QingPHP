<?php
/**
 * IndexController 默认控制器 
 * 
 * @uses QingPHP
 * @uses _Controller_Abstract
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
class IndexController extends QingPHP_Controller_Abstract
{
    /**
     * init 初始化 
     * 
     * @access public
     * @return void
     */
	public function init()
	{
		//关闭视图
		$this->enableView(false);
	}

    /**
     * indexAction 
     * 
     * @access public
     * @return void
     */
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
