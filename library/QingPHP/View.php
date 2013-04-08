<?php
require 'Third/Smarty/Smarty.class.php';
class QingPHP_View implements QingPHP_View_Interface
{
	public $smarty;
	public function __construct($tmplPath = null, $extraParams = array())
	{
        $this->smarty = new Smarty; 
        if ($tmplPath != null) {
            $this->setScriptPath($tmplPath);
        } 
        foreach ((array) $extraParams as $key => $val) {
            $this->smarty->$key = $val;
        }
    }

    public function setScriptPath($path)
    {
        if (is_readable($path)) {
            $this->smarty->template_dir = $path;
            return;
        } 
        throw new QingPHP_Exception('Invalid path provided', 500);
    }

    public function getScriptPath()
    {
        return $this->smarty->template_dir;
    }
    public function __set($key, $val)
    {
        $this->smarty->assign($key, $val);
    }

    public function __isset($key)
    {
        return ($this->smarty->get_template_vars($key) !== null);
    }

    public function __unset($key)
    {
        $this->smarty->clear_assign($key);
    }

    public function assign($spec, $val = null)
    {
        if (is_array($spec)) {
            $this->smarty->assign($spec);
            return;
        } 
        $this->smarty->assign($spec, $val);
    }

    public function clearVars()
    {
        $this->smarty->clear_all_assign();
    }

    public function render($name, $val = null) 
    {
        return $this->smarty->fetch($name);
    }

    public function display($name, $value = null)
    {
        echo $this->smarty->fetch($name);
    }
}