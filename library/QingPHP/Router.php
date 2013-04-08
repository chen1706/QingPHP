<?php
final class QingPHP_Router implements QingPHP_Route_Interface
{
	protected $rules = array();
    private static $instance = null;

	private function __construct()
    {
        $config = QingPHP::getApplication()->config();        
        $this->defaultController = $config['default_controller'];
        $this->defaultAction     = $config['default_action'];
    }

    public static function instance()
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function route(QingPHP_Request_Abstract $request)
    {
        $controller = $request->get('c');
        $action     = $request->get('a');
        $controllerName = $controller ?: $this->defaultController;
        $actionName     = $action ?: $this->defaultAction;
        return array('controller' => ucfirst(strtolower($controllerName)), 'action' => strtolower($actionName));
    }
}