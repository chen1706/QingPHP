<?php
/**
 * QingPHP_Controller_Abstract 控制器 
 * 
 * @abstract
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
abstract class QingPHP_Controller_Abstract
{
	protected $view;
    protected $request;
    protected $response;
	protected $enableView = true;

    /**
     * __construct 构造函数 
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->init();
        if ($this->enableView) {
            $this->initView();
        }
    }

    /**
     * init 控制器初始化 
     * 
     * @access public
     * @return void
     */
    public function init()
    {
        //动态改变初始化哪些内容
    }

    /**
     * preRunning 前置action 
     * 
     * @access public
     * @return void
     */
    public function preRunning()
    {
    }
    
    /**
     * postRunning 后置action 
     * 
     * @access public
     * @return void
     */
    public function postRunning()
    {
    }

    /**
     * enableView 是否打开视图 
     * 
     * @param mixed $flag 
     * @access public
     * @return void
     */
    public function enableView($flag = true)
    {
        $this->enableView = (bool) $flag;
        if (!$flag) {
            $this->view = null;
        }
    }

    /**
     * getRequest 获取request对象 
     * 
     * @access public
     * @return void
     */
    public function getRequest()
    {
        $this->request = QingPHP_Registry::get('request');
        return $this->request;
    }

    /**
     * getResponse 获取response对象 
     * 
     * @access public
     * @return void
     */
    public function getResponse()
    {
        $this->response = QingPHP_Registry::get('response');
        return $this->response;
    }

    /**
     * getView 获取视图对象 
     * 
     * @access public
     * @return void
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * initView 初始化视图 
     * 
     * @access public
     * @return void
     */
    public function initView()
    {
        $this->view = new QingPHP_View(QingPHP_Config::instance()->get('smarty'));
    }

    /**
     * setViewPath 设置视图路径 
     * 
     * @param mixed $viewDirectory 
     * @access public
     * @return void
     */
    public function setViewPath($viewDirectory)
    {
        $this->view->setViewPath($viewDirectory);
    }

    /**
     * display 展示 
     * 
     * @param mixed $tpl 
     * @access public
     * @return void
     */
    public function display($tpl = null)
    {
        //如果$tpl为null 则response (json, seria) 数据
        if ($tpl == null) {
            $this->getResponse()->response();
        } else {
            $this->view->display($tpl);
        }
    }

    /**
     * redirect 
     * 
     * @param mixed $url 
     * @access public
     * @return void
     */
    public function redirect($url)
    {
        header('Location: ' . $url);
    }
}
