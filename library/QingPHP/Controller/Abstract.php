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
    protected $request;
    protected $response;

    /**
     * __construct 构造函数 
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        $this->init();
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
        $this->getRequest();
        $this->getResponse();
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

    public function assign($key, $val = null, $autoResponse = false)
    {
        $this->response->setResponse($key, $val, $autoResponse);
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
        $this->response->display($tpl);
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
