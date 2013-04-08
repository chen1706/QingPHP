<?php
/**
 * QingPHP_Request_Http 
 * 
 * @uses QingPHP
 * @uses _Request_Abstract
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
class QingPHP_Request_Http extends QingPHP_Request_Abstract
{
    /**
     * get get数组 
     * 
     * @param mixed $key 
     * @access public
     * @return void
     */
	public function get($key)
	{
		//todo 参数过滤
		if (!isset($_GET[$key])) {
            return null;
        }

        if (!is_array($_GET[$key])) {
            return htmlspecialchars(trim($_GET[$key]));
        }

        foreach ($_GET[$key] as $key => $val) {
            $params[$key] = htmlspecialchars(trim($val));
		}
		return $params;
	}

	public function query($name){}
	public function post($name){}
	public function server($name){}
	public function cookie($name){}
	public function file($name){}
	public function isGet(){}
	public function isPost(){}
	public function isHead(){}
	public function isXmlHttpRequest(){}
	public function isPut(){}
	public function isDelete(){}
	public function isOption(){}
}
