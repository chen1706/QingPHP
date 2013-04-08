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
    public function query($key, $xssClean = true)
    {
        if ($key === null AND !empty($_REQUEST)) {
            $ret = array();
            foreach (array_keys($_REQUEST) as $index) {
                $ret[$index] = $this->fetchFromArray($_REQUEST, $index, $xssClean);
            }
            return $ret;
        }
        return $this->fetchFromArray($_REQUEST, $key, $xssClean);
    }

    /**
     * get get数组 
     * 
     * @param mixed $key 
     * @access public
     * @return void
     */
	public function get($key, $xssClean = true)
	{
		if ($key === null AND !empty($_GET)) {
            $ret = array();
            foreach (array_keys($_GET) as $index) {
                $ret[$index] = $this->fetchFromArray($_GET, $index, $xssClean);
            }
            return $ret;
        }
        return $this->fetchFromArray($_GET, $key, $xssClean);
	}

    public function post($key, $xssClean = true)
    {
        if ($key === null AND !empty($_POST)) {
            $ret = array();
            foreach (array_keys($_POST) as $index) {
                $ret[$index] = $this->fetchFromArray($_POST, $index, $xssClean);
            }
            return $ret;
        }
        return $this->fetchFromArray($_POST, $key, $xssClean);
    }

    public function server($key, $xssClean = true)
    {
        if ($key === null AND !empty($_SERVER)) {
            $ret = array();
            foreach (array_keys($_SERVER) as $index) {
                $ret[$index] = $this->fetchFromArray($_SERVER, $index, $xssClean);
            }
            return $ret;
        }
        return $this->fetchFromArray($_SERVER, $key, $xssClean);
    }

    public function cookie($key, $xssClean = true)
    {
        if ($key === null AND !empty($_COOKIE)) {
            $ret = array();
            foreach (array_keys($_COOKIE) as $index) {
                $ret[$index] = $this->fetchFromArray($_COOKIE, $index, $xssClean);
            }
            return $ret;
        }
        return $this->fetchFromArray($_COOKIE, $key, $xssClean);

    }

	public function file($key){}

    public function fetchFromArray($arr, $key, $xssClean = true)
    {
        if (!isset($arr[$key])) {
            return false;
        }
        if ($xssClean === true) {
            return $this->xssClean($arr[$key]);
        }
        return $arr[$key];
    }

    public function isGet()
    {
        return ($this->server('REQUEST_METHOD') === 'GET');
    }

    public function isPost()
    {
        return ($this->server('REQUEST_METHOD') === 'POST');
    }
    
    public function isHead()
    {
        return ($this->server('REQUEST_METHOD') === 'HEAD');
    }

    public function isXmlHttpRequest()
    {
        return ($this->server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest');
    }

    public function isPut()
    {
        return ($this->server('REQUEST_METHOD') === 'PUT');
    }
    
    public function isDelete()
    {
        return ($this->server('REQUEST_METHOD') === 'DELETE');
    }

    public function isOption()
    {
        return ($this->server('REQUEST_METHOD') === 'OPTIONS');
    }

    private function xssClean($val)
    {
        return htmlspecialchars($val);
    }
}
