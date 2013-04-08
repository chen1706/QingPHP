<?php
interface QingPHP_View_Interface
{
	public function render($tpl, $tplVars = null);
	public function display($tpl, $tplVars = null);
	public function assign($name, $value = null);
	public function setViewPath($viewDirectory);
}