<?php
class QingPHP_Registry
{
	private static $instance = null;
	protected static $entries = array();

	public function __construct()
	{
	}

	public static function instance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}		
		return self::$instance;
	}

	public static function set($name, $val)
	{
		return self::$entries[$name] = $val;
	}

	public static function get($name)
	{
		if (isset(self::$entries[$name])) {
			return self::$entries[$name];
		}
		return null;
	}

	public static function has($name)
	{
		return isset(self::$entries[$name]);
	}

	public static function del($name)
	{
		unset(self::$entries[$name]);
		return true;
	}
}