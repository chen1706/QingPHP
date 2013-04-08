<?php
/**
 * QingPHP 
 * 
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
class QingPHP 
{
    private static $application = null;
    
    /**
     * createApp 创建app 
     * 
     * @param array $config 
     * @static
     * @access public
     * @return void
     */
    public static function createApp(array $config = null)
    {
        self::init($config);
        $className = 'QingPHP_Application';
        return new $className($config);
    }
    
    /**
     * init 初始化 
     * 
     * @param mixed $config 
     * @static
     * @access public
     * @return void
     */
    public static function init(&$config)
    {        
        //注册自动加载函数
        set_include_path($config['include_path']);        
        spl_autoload_register('QingPHP::loadClass');
        //设置时区
        if (isset($config['default_timezone'])) {
            date_default_timezone_set($config['default_timezone']);
        } 
    }

    /**
     * getApplication 获取app实例 
     * 
     * @static
     * @access public
     * @return void
     */
    public static function getApplication()
    {        
        return self::$application;
    }

    /**
     * setApplication 存储当前实例 
     * 
     * @param mixed $app 
     * @static
     * @access public
     * @return void
     */
    public static function setApplication($app)
    {
        if (!isset(self::$application)) {
            QingPHP::$application = $app;
        } else {
            throw QingPHP_Exception('QingPHP application can only be created once!');
        }
    }

    /**
     * loadClass 自动加载类 
     * 
     * @param mixed $className 
     * @param mixed $directory 
     * @static
     * @access public
     * @return void
     */
    public static function loadClass($className, $directory = null)
    {
        $class = strtolower($className);
        if (substr($class, 0, 16) === 'smarty_internal_' || $class == 'smarty_security') {
            $fileName = 'Third/Smarty/sysplugins/' . $class . '.php';
        } else {
            $fileName = str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';
        }
        if (strpos($fileName, '\\') !== false) {
            $fileName = str_replace('\\', DIRECTORY_SEPARATOR, $fileName);
        }
        if ($directory) {
            $fileName = $directory . DIRECTORY_SEPARATOR . $fileName;
        }
        return include_once $fileName;
    }
}
