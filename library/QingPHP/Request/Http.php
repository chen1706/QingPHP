<?php
class QingPHP_Request_Http extends QingPHP_Request_Abstract
{
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

	public function query(string $name){}
	public function post(string $name){}
	public function server(string $name){}
	public function cookie(string $name){}
	public function file(string $name){}
	public function isGet(){}
	public function isPost(){}
	public function isHead(){}
	public function isXmlHttpRequest(){}
	public function isPut(){}
	public function isDelete(){}
	public function isOption(){}
}