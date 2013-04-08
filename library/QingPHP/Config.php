<?php
class QingPHP_Config implements Iterator, ArrayAccess, Countable
{
	protected static $instance = null;
	protected $config = array();

	protected function __construct() 
	{
	}

	public static function instance()
	{
		if(!self::$instance) {
			self::$instance = new self(); 
		}
		return self::$instance; 
	} 

	public function get($key = null)
	{
		if ($key !== null) {
			return $this->config[$key];
		}
		return null;
	}

	public function __get($key)
	{
		if (is_array($this->config[$key])) {
			$obj = (object) $this->config[$key];
		} else {
			$obj = $this->config[$key];
		}		
		return $obj;
	}

	public function __isset($key)
	{
		return isset($this->config[$key]);
	}

	public function set($key, $val)
	{
		return $this->config[$key] = $val;
	}

	public function __toString()
	{
		
	}

	public function count()
	{
		return count($this->config);
	}

	public function offsetGet($key)
	{
		if ($key !== null) {
			return $this->config[$key];
		}
		return null;
	}

	public function offsetSet($key, $val)
	{
		return $this->config[$key] = $val;
	}

	public function offsetExists($key)
	{
		return isset($this->config[$key]); 
	}

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