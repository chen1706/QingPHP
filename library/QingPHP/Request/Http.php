<?php
/**
 * QingPHP_Request_Http 
 * 
 * @uses QingPHP_Request_Abstract
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
class QingPHP_Request_Http extends QingPHP_Request_Abstract
{
    /**
     * query 
     * 查询参数
     * 
     * @param mixed $key key 
     * @param mixed $xssClean xssClean 
     * 
     * @return void
     */
    public function query($key, $xssClean = true)
    {
        if ($key === null && !empty($_REQUEST)) {
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
		if ($key === null && !empty($_GET)) {
            $ret = array();
            foreach (array_keys($_GET) as $index) {
                $ret[$index] = $this->fetchFromArray($_GET, $index, $xssClean);
            }
            return $ret;
        }

        return $this->fetchFromArray($_GET, $key, $xssClean);
	}

    /**
     * post 
     * 
     * @param mixed $key key 
     * @param mixed $xssClean xssClean 
     * 
     * @return void
     */
    public function post($key, $xssClean = true)
    {
        if ($key === null && !empty($_POST)) {
            $ret = array();
            foreach (array_keys($_POST) as $index) {
                $ret[$index] = $this->fetchFromArray($_POST, $index, $xssClean);
            }
            return $ret;
        }

        return $this->fetchFromArray($_POST, $key, $xssClean);
    }

    /**
     * server 
     * 
     * @param mixed $key key 
     * @param mixed $xssClean xssClean 
     * 
     * @return void
     */
    public function server($key, $xssClean = true)
    {
        if ($key === null && !empty($_SERVER)) {
            $ret = array();
            foreach (array_keys($_SERVER) as $index) {
                $ret[$index] = $this->fetchFromArray($_SERVER, $index, $xssClean);
            }
            return $ret;
        }

        return $this->fetchFromArray($_SERVER, $key, $xssClean);
    }

    /**
     * cookie 
     * 
     * @param mixed $key key 
     * @param mixed $xssClean xssClean 
     * 
     * @return void
     */
    public function cookie($key, $xssClean = true)
    {
        if ($key === null && !empty($_COOKIE)) {
            $ret = array();
            foreach (array_keys($_COOKIE) as $index) {
                $ret[$index] = $this->fetchFromArray($_COOKIE, $index, $xssClean);
            }
            return $ret;
        }

        return $this->fetchFromArray($_COOKIE, $key, $xssClean);

    }

	public function file($key){}

    /**
     * fetchFromArray 
     * 
     * @param mixed $arr arr 
     * @param mixed $key key 
     * @param mixed $xssClean xssClean 
     * 
     * @return void
     */
    public function fetchFromArray($arr, $key, $xssClean = true)
    {
        if ($key === null || !isset($arr[$key])) {
            return null;
        }
        if ($xssClean === true) {
            return $this->xssClean($arr[$key]);
        }

        return $arr[$key];
    }
    
    /**
     * isGet 
     * 
     * 
     * @return void
     */
    public function isGet()
    {
        return ($this->server('REQUEST_METHOD') === 'GET');
    }

    /**
     * isPost 
     * 
     * 
     * @return void
     */
    public function isPost()
    {
        return ($this->server('REQUEST_METHOD') === 'POST');
    }
    
    /**
     * isHead 
     * 
     * 
     * @return void
     */
    public function isHead()
    {
        return ($this->server('REQUEST_METHOD') === 'HEAD');
    }

    /**
     * isXmlHttpRequest 
     * 
     * 
     * @return void
     */
    public function isXmlHttpRequest()
    {
        return ($this->server('HTTP_X_REQUESTED_WITH') === 'XMLHttpRequest');
    }

    /**
     * isPut 
     * 
     * 
     * @return void
     */
    public function isPut()
    {
        return ($this->server('REQUEST_METHOD') === 'PUT');
    }
    
    /**
     * isDelete 
     * 
     * 
     * @return void
     */
    public function isDelete()
    {
        return ($this->server('REQUEST_METHOD') === 'DELETE');
    }

    /**
     * isOption 
     * 
     * 
     * @return void
     */
    public function isOption()
    {
        return ($this->server('REQUEST_METHOD') === 'OPTIONS');
    }

    /**
     * xssClean 
     * 
     * @param mixed $val val 
     * 
     * @return void
     */
    private function xssClean($val)
    {
        return trim(htmlspecialchars($val));
    }
}
