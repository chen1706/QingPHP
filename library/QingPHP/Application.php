<?php
/**
 * QingPHP_Application 
 * 
 * @final
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
final class QingPHP_Application
{
    /**
     * __construct 
     * 
     * @param array $config 
     * @access public
     * @return void
     */
	public function __construct(array $config = null)
    {
    	//保存当前应用
    	QingPHP::setApplication($this);
        //配置注册   
        $this->registerConfig($config); 
        //注册request response对象
        QingPHP_Registry::set('request', new QingPHP_Request_Http);
        QingPHP_Registry::set('response', new QingPHP_Response_Http);
    }

    /**
     * run 程序执行开始
     * 
     * @access public
     * @return void
     */
    public function run()
    {
        try {
            $this->_run();
        } catch (QingPHP_Exception $e) {
            throw $e;
        }
    }

    /**
     * _run 具体执行 
     * 
     * @access private
     * @return void
     */
    private function _run() 
    {
        $request = QingPHP_Registry::get('request');
        $routerArr = QingPHP_Router::instance()->route($request);        
        $controller  = $routerArr['controller'] . 'Controller';
        $action      = $routerArr['action'] . 'Action';        
        $controllerClass = ucfirst($controller);
        $controller = new $controllerClass;

        // 需要采用反射去执行方法
        if (method_exists($controller, $action)) {
            $this->runAction($controller, $action);
        } else {
            throw new QingPHP_Application_Exception('Not found \'' . $action . '\' action in \'' . 
                $controllerClass . '\'');
        }
    }
    
    /**
     * runAction 执行action 
     * 
     * @param mixed $class 
     * @param mixed $action 
     * @access private
     * @return void
     */
    private function runAction($class, $action)
    {
        $class->preRunning();
        $class->$action();
        $class->postRunning();
    }

    /**
     * registerConfig 注册配置 
     * 
     * @param mixed $config 
     * @access public
     * @return void
     */
	public function registerConfig(&$config) 
    {
    	$registry = QingPHP_Config::instance();
        foreach ($config as $key => $val) {
            $registry->set($key, $val);
        }
	}

    /**
     * config 获取当前配置 
     * 
     * @access public
     * @return void
     */
    public function config()
    {
        return QingPHP_Config::instance();
    }
}
