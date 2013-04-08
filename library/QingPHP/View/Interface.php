<?php
/**
 * QingPHP_View_Interface 接口 
 * 
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
interface QingPHP_View_Interface
{
	public function render($tpl, $tplVars = null);
	public function display($tpl, $tplVars = null);
	public function assign($key, $value = null);
	public function setViewPath($viewDirectory);
}
