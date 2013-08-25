<?php
/**
 * QingPHP 主程序 
 * 
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
class QingPHP 
{
    /**
     * app 实例
     */
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
        $environment = $config['environment'] ?: 'development';
        define('ENVIRONMENT', $environment);

        //注册自动加载函数
        set_include_path($config['include_path']);        
        spl_autoload_register('QingPHP::loadClass');

        //设置时区
        if (isset($config['default_timezone'])) {
            date_default_timezone_set($config['default_timezone']);
        } 

        $errorType = ENVIRONMENT == 'development' ?  E_ALL | E_STRICT : (E_ALL & ~E_NOTICE) | E_STRICT;
        set_error_handler('QingPHP::errorHandler', $errorType);

        /** 
         * 注册异常抓捕函数
         * 当PHP遇到抛出异常的时候，会启动QingPHP::exceptionHandler()
         * 由于这个函数是个静态函数，所以不需要实例化对象
         */
        set_exception_handler('QingPHP::exceptionHandler');
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

    /** 
     * 默认的异常处理方法 进行日志记录或者打印到当前页面
     *
     * @param Exception $exc
     * @static
     * @access public
     * @return void
     */
    public static function exceptionHandler($exception)
    {   
        /** 
         *  读取配置文件中的错误日志信息
         *  如果存在配置文件错误日志信息，则将错误信息交给QingPHP_Log
         *  如果不存在，则直接输出
         */
        if (ENVIRONMENT == 'development') {
            QingPHP_Exception::showException($exception);
        } else {
            /**
             * 1.调用QingPHP_Log::getLogger()，QingPHP_Log::getLogger()会返回一个logger对象
             * 2.调用logger对象的error方法，将错误信息提交给logger，并指定输出格式
             */
            QingPHP_Log::getLogger()->error("phpexception:code:%d\nmessage:%s\nfile:%s:%d\ntrace:%s", 
                $exception->getCode(), $exception->getMessage(), $exception->getFile(), $exception->getLine(), 
                $exception->getTraceAsString());
        }
    }

    /**
     * PHP错误信息处理的回调方法
     *
     * @param intval $errno
     * @param string $errstr
     * @param string $errfile
     * @param intval $errline
     * @param string $errorcontext
     * @static
     * @access public
     * @return void
     */
    public static function errorHandler($errno, $errstr, $errfile, $errline)
    {
        if (ENVIRONMENT == 'development') {
            $errorStr = sprintf("phperror:\nerrno:%d\nmessage:%s\nfile:%s:%d\n\n", $errno, $errstr, $errfile, $errline);
        } else {
            if (in_array($errno, array(E_NOTICE, E_USER_NOTICE))) {
                $level = QingPHP_Log::NOTICE;
            } elseif (in_array($errno, array(E_WARNING, E_USER_WARNING))) {
                $level = QingPHP_Log::WARN;
            } else {
                $level = QingPHP_Log::ERROR;
            }
            QingPHP_Log::getLogger()->log($level, "phperror:\nerrno:%d\nmessage:%s\nfile:%s:%d\n\n", 
                $errno, $errstr, $errfile, $errline);
        }
    }
}
