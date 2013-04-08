<?php
abstract class QingPHP_Controller_Abstract
{
	protected $view;
    protected $request;
    protected $response;
	protected $enableView = true;

    public function __construct()
    {
        $this->init();
        if ($this->enableView) {
            $this->initView();
        }
    }

    public function init()
    {
        //动态改变初始化哪些内容
    }

    public function preRunning()
    {
    }
    
    public function postRunning()
    {
    }

    public function enableView($flag = true)
    {
        $this->enableView = (bool) $flag;
    }

    public function getRequest()
    {
        $this->request = QingPHP_Registry::get('request');
        return $this->request;
    }

    public function getResponse()
    {
        $this->response = QingPHP_Registry::get('response');
        return $this->response;
    }

    public function getView()
    {
        return $this->view;
    }

    public function initView()
    {
        $this->view = new QingPHP_View(null, QingPHP_Config::instance()->get('smarty'));
    }

    public function setViewPath($viewDirectory)
    {
        $this->view->setViewPath($viewDirectory);
    }

    public function display($tpl)
    {
        $this->view->display($tpl);
    }

    public function redirect($url)
    {
        //head();
    }
}