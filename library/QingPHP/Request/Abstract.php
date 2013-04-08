<?php
/**
 * QingPHP_Request_Abstract 请求 
 * 
 * @abstract
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
abstract class QingPHP_Request_Abstract
{
	protected $method;
	protected $controller;
	protected $action;
	protected $params;
	protected $baseUri;
	protected $requestUri;

	public function __construct()
	{
		//构造函数
	}

    /**
     * getControllerName 
     * 
     * @access public
     * @return void
     */
	public function getControllerName()
	{
		return $this->controller;
	}

    /**
     * getActionName 
     * 
     * @access public
     * @return void
     */
	public function getActionName()
	{
		return $this->action;
	}

	public function setControllerName($name)
	{
		return $this->controller = $name;
	}

    /**
     * setActionName 
     * 
     * @param string $name 
     * @access public
     * @return void
     */
	public function setActionName($name)
	{
		return $this->action = $name;
	}

    /**
     * getParams 
     * 
     * @access public
     * @return void
     */
	public function getParams()
	{
		return $this->params;
	}

    /**
     * getParam 
     * 
     * @param mixed $name 
     * @param mixed $default 
     * @access public
     * @return void
     */
	public function getParam($name, $default = null)
	{

	}

    /**
     * setParam 
     * 
     * @param mixed $name 
     * @param mixed $val 
     * @access public
     * @return void
     */
	public function setParam($name, $val)
	{

	}

    /**
     * getMethod 
     * 
     * @access public
     * @return void
     */
	public function getMethod()
	{

	}

	/**
	 * 抽象方法
	 */
	abstract public function query($name);
	abstract public function post($name);
	abstract public function get($name);
	abstract public function server($name);
	abstract public function cookie($name);
	abstract public function file($name);
	abstract public function isGet();
	abstract public function isPost();
	abstract public function isHead();
	abstract public function isXmlHttpRequest();
	abstract public function isPut();
	abstract public function isDelete();
	abstract public function isOption();
}
