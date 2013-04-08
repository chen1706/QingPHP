<?php
/**
 * QingPHP_Response_Abstract 输出抽象类 
 * 
 * @abstract
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
abstract class QingPHP_Response_Abstract
{
	protected $body = array();
	protected $header = array();

    /**
     * setBody 设置body 
     * 
     * @param mixed $body 
     * @param mixed $name 
     * @access public
     * @return void
     */
	public function setBody($body, $name = null)
	{
		$this->body = array();
		return $this->body[] = $body;
	}

    /**
     * prependBody 头部追加 
     * 
     * @param mixed $body 
     * @param mixed $name 
     * @access public
     * @return void
     */
	public function prependBody($body, $name)
	{
		return array_unshift($this->body, $body);
	}

    /**
     * appendBody 尾部追加 
     * 
     * @param mixed $body 
     * @param mixed $name 
     * @access public
     * @return void
     */
	public function appendBody($body, $name)
	{
		return $this->body[] = $body;
	}

    /**
     * clearBody 清除body 
     * 
     * @param mixed $body 
     * @access public
     * @return void
     */
	public function clearBody($body)
	{
		return $this->body = array();
	}

    /**
     * getBody 获取body 
     * 
     * @access public
     * @return void
     */
	public function getBody()
	{
		return $this->body;
	}

    /**
     * response 输出 
     * 
     * @access public
     * @return void
     */
	public function response()
	{
	}
}
