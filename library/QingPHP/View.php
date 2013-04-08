<?php
require 'Third/Smarty/Smarty.class.php';

/**
 * QingPHP_View 视图 
 * 
 * @uses QingPHP_View_Interface
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
class QingPHP_View implements QingPHP_View_Interface
{
	public $smarty;

    /**
     * __construct 
     * 
     * @param mixed $tplPath 
     * @param array $extraParams 
     * @access public
     * @return void
     */
	public function __construct(array $extraParams = array(), $tplPath = null)
	{
        $this->smarty = new Smarty; 
        foreach ((array) $extraParams as $key => $val) {
            $this->smarty->$key = $val;
        }
        if ($tplPath != null) {
            $this->setViewPath($tplPath);
        }
    }

    /**
     * setViewPath 
     * 
     * @param mixed $path 
     * @access public
     * @return void
     */
    public function setViewPath($path)
    {
        if (is_readable($path)) {
            return $this->smarty->template_dir = $path;
        } 
        throw new QingPHP_Exception('Invalid path provided', 500);
    }

    /**
     * __set 
     * 
     * @param mixed $key 
     * @param mixed $val 
     * @access public
     * @return void
     */
    public function __set($key, $val)
    {
        return $this->smarty->assign($key, $val);
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
        return ($this->smarty->get_template_vars($key) !== null);
    }

    /**
     * __unset 
     * 
     * @param mixed $key 
     * @access public
     * @return void
     */
    public function __unset($key)
    {
        return $this->smarty->clear_assign($key);
    }

    /**
     * assign 
     * 
     * @param mixed $spec 
     * @param mixed $val 
     * @access public
     * @return void
     */
    public function assign($spec, $val = null)
    {
        if (is_array($spec)) {
            return $this->smarty->assign($spec);
        } 
        $this->smarty->assign($spec, $val);
    }

    /**
     * clearVars 
     * 
     * @access public
     * @return void
     */
    public function clearVars()
    {
        $this->smarty->clear_all_assign();
    }

    /**
     * render 
     * 
     * @param mixed $name 
     * @param mixed $val 
     * @access public
     * @return void
     */
    public function render($name, $val = null) 
    {
        return $this->smarty->fetch($name);
    }

    /**
     * display 
     * 
     * @param mixed $file 
     * @param mixed $value 
     * @access public
     * @return void
     */
    public function display($file, $value = null)
    {
        $file = $file . QingPHP_Config::instance()->get('tpl_extention');
        echo $this->smarty->fetch($file);
    }
}
