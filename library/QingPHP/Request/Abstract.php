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
     * getController 
     * 
     * @access public
     * @return void
     */
	public function getController()
	{
		return $this->controller;
	}

    /**
     * getAction 
     * 
     * @access public
     * @return void
     */
	public function getAction()
	{
		return $this->action;
	}

    /**
     * setController 
     * 
     * @param mixed $controller
     * 
     * @return void
     */
	public function setController($controller)
	{
		return $this->controller = $controller;
	}

    /**
     * setAction 
     * 
     * @param string $key 
     * @access public
     * @return void
     */
	public function setAction($action)
	{
		return $this->action = $action;
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
     * @param mixed $key 
     * @param mixed $default 
     * @access public
     * @return void
     */
	public function getParam($key, $default = null)
	{
        return $this->params[$key] ?: $default;
	}

    /**
     * setParam 
     * 
     * @param mixed $key 
     * @param mixed $val 
     * @access public
     * @return void
     */
	public function setParam($key, $val)
	{
        return $this->params[$key] = $val;
	}

    /**
     * getMethod 
     * 
     * @access public
     * @return void
     */
	public function getMethod()
	{
        return $this->server('REQUEST_METHOD');
	}

    /**
     * getRequestUri 
     * 
     * 
     * @return void
     */
    public function getRequestUri()
    {
        return $this->server('REQUEST_URI');
    }

	/**
	 * 抽象方法
	 */
	abstract public function query($key, $xssClean);
	abstract public function post($key, $xssClean);
	abstract public function get($key, $xssClean);
	abstract public function server($key, $xssClean);
	abstract public function cookie($key, $xssClean);
	abstract public function file($key);
	abstract public function isGet();
	abstract public function isPost();
	abstract public function isHead();
	abstract public function isXmlHttpRequest();
	abstract public function isPut();
	abstract public function isDelete();
	abstract public function isOption();
}
