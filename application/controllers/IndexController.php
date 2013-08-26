<?php
/**
 * IndexController 默认控制器 
 * 
 * @uses QingPHP
 * @uses _Controller_Abstract
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
class IndexController extends QingPHP_Controller_Abstract
{
    /**
     * indexAction 
     * 
     * @access public
     * @return void
     */
    public function indexAction()
    {
    	$this->assign('username', 'chen1706');
    	$this->assign('cost_time', microtime(true) - START_TIME);
    	$this->display('hello');    	
    }

    /**
     * empty 
     * 默认action
     *
     * @return void
     */
    public function emptyAction()
    {
        $this->assign('username', 'chen1706');
    	$this->assign('cost_time', microtime(true) - START_TIME);
    	$this->display('hello');    	
    }
}
