<?php
/**
 * QingPHP_Registry 全局注册 
 * 
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
class QingPHP_Registry
{
	private static $instance = null;
	protected static $entries = array();

	public function __construct()
	{
	}

    /**
     * instance 
     * 
     * @static
     * @access public
     * @return void
     */
	public static function instance()
	{
		if (!isset(self::$instance)) {
			self::$instance = new self();
		}		
		return self::$instance;
	}

    /**
     * set 设置
     * 
     * @param mixed $name 
     * @param mixed $val 
     * @static
     * @access public
     * @return void
     */
	public static function set($name, $val)
	{
		return self::$entries[$name] = $val;
	}

    /**
     * get 获取 
     * 
     * @param mixed $name 
     * @static
     * @access public
     * @return void
     */
	public static function get($name)
	{
		if (isset(self::$entries[$name])) {
			return self::$entries[$name];
		}
		return null;
	}

    /**
     * has 检查 
     * 
     * @param mixed $name 
     * @static
     * @access public
     * @return void
     */
	public static function has($name)
	{
		return isset(self::$entries[$name]);
	}

    /**
     * del 删除 
     * 
     * @param mixed $name 
     * @static
     * @access public
     * @return void
     */
	public static function del($name)
	{
		unset(self::$entries[$name]);
		return true;
	}
}
