<?php
/**
 * QingPHP_Config 配置类 
 * 
 * @uses Iterator
 * @uses ArrayAccess
 * @uses Countable
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
class QingPHP_Config implements Iterator, ArrayAccess, Countable
{
	protected static $instance = null;
	protected $config = array();

	protected function __construct() 
	{
	}

    /**
     * instance 单例 
     * 
     * @static
     * @access public
     * @return void
     */
	public static function instance()
	{
		if(!self::$instance) {
			self::$instance = new self(); 
		}
		return self::$instance; 
	} 

    /**
     * get 
     * 
     * @param mixed $key 
     * @access public
     * @return void
     */
	public function get($key = null)
	{
		if ($key !== null) {
			return $this->config[$key];
		}
		return null;
	}

    /**
     * __get 魔术方法 
     * 
     * @param mixed $key 
     * @access public
     * @return void
     */
	public function __get($key)
	{
		if (is_array($this->config[$key])) {
			$obj = (object) $this->config[$key];
		} else {
			$obj = $this->config[$key];
		}		
		return $obj;
	}

    /**
     * __isset 
     * 
     * @param mixed $key 
     * @access public
     * @return void
     */
	public function __isset($key)
	{
		return isset($this->config[$key]);
	}

	public function set($key, $val)
	{
		return $this->config[$key] = $val;
	}

    /**
     * count 
     * 
     * @access public
     * @return void
     */
	public function count()
	{
		return count($this->config);
	}

    /**
     * offsetGet 
     * 
     * @param mixed $key 
     * @access public
     * @return void
     */
	public function offsetGet($key)
	{
		if ($key !== null) {
			return $this->config[$key];
		}
		return null;
	}

    /**
     * offsetSet 
     * 
     * @param mixed $key 
     * @param mixed $val 
     * @access public
     * @return void
     */
	public function offsetSet($key, $val)
	{
		return $this->config[$key] = $val;
	}

    /**
     * offsetExists 
     * 
     * @param mixed $key 
     * @access public
     * @return void
     */
	public function offsetExists($key)
	{
		return isset($this->config[$key]); 
	}

    /**
     * offsetUnset 
     * 
     * @param mixed $key 
     * @access public
     * @return void
     */
	public function offsetUnset($key)
	{
		return $this->config[$key] = null;
	}

	public function rewind()
	{
	}

	public function key()
	{
	}

	public function next()
	{
	}

	public function current()
	{
	}

	public function valid()
	{
	}
}
