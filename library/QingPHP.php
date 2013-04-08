<?php
class QingPHP 
{
    private static $app = null;
    
    public static function createApp(array $config = null)
    {
        self::init($config);
        $className = 'QingPHP_Application';
        return new $className($config);
    }
    
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

    public static function getApplication()
    {        
        return self::$app;
    }

    public static function setApplication($app)
    {
        if (self::$app === null || $app === null) {
            QingPHP::$app = $app;
        } else {
            throw QingPHP_Exception('QingPHP application can only be created once!');
        }
    }

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

        include_once $fileName;
        return true;
    }
}
