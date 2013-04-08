<?php
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

	public function getControllerName()
	{
		return $this->controller;
	}

	public function getActionName()
	{
		return $this->action;
	}

	public function setControllerName(string $name)
	{
		return $this->controller = $name;
	}

	public function setActionName(string $name)
	{
		return $this->action = $name;
	}

	public function getParams()
	{
		return $this->params;
	}

	public function getParam(string $name, $default = null)
	{

	}

	public function setParam(string $name, $val)
	{

	}

	public function getMethod()
	{

	}

	/**
	 * 抽象方法
	 */
	abstract public function query(string $name);
	abstract public function post(string $name);
	abstract public function get($name);
	abstract public function server(string $name);
	abstract public function cookie(string $name);
	abstract public function file(string $name);
	abstract public function isGet();
	abstract public function isPost();
	abstract public function isHead();
	abstract public function isXmlHttpRequest();
	abstract public function isPut();
	abstract public function isDelete();
	abstract public function isOption();
}