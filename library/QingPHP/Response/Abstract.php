<?php
/**
 * QingPHP_Response_Abstract 输出抽象类 
 * 
 * @abstract
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
abstract class QingPHP_Response_Abstract
{
    /**
     * header 头信息 
     */
    protected $header = array();

    /**
     * 输出的内容变量数组
     */
    protected $response = array();

    /**
     * 只传递给smarty的变量集合 不进行接口输出
     */
    protected $autoResponse = array();

    /**
     * setResponse 
     * 
     * @param mixed $key key 
     * @param mixed $val val 
     * @param mixed $auto auto 
     * 
     * @return void
     */
    public function setResponse($key, $val = null, $auto = false)
    {
        if (func_num_args() == 1 || $val === null) {
            if (!is_array($this->response)) {
                $this->response = $key;
            } else {
                if (is_array($key)) {
                    foreach ($key as $k => $v) {
                        $this->response[$k] = $v; 
                    }   
                } else {
                    $this->response[$key] = $val;
                }   
            }   
        } else {
            if (!is_array($this->response)) { 
                if ($this->response) {
                    $response = $this->response;
                    $this->response = array();
                    $this->response[$response] = null;
                }   
            }   
            $auto ? ((array) $this->autoResponse[$key] = $val) : ((array) $this->response[$key] = $val);
        }   
    }   

    /**
     * getResponse 获取返回对象
     * 
     * @return mixed
     */
    public function getResponse($auto = false)
    {
        return $auto ? $this->autoResponse : $this->response;
    }

    /**
     * 增加输出的http头
     * 
     * @param string $key 
     * @param string $val 如果为空key可为数组传入
     * @return void
     */
    public function setHeader($key, $val = null)
    {
        if (func_num_args() == 1) {
            $this->header = $key;
        } else {
            $this->header[$key] = $val;
        }
    }

    /**
     * getHeader 
     * 返回header信息 
     * 
     * @return void
     */
    public function getHeader()
    {
        return $this->header;
    }

    /**
     * display 
     * 显示 
     * 
     * @return void
     */
    abstract public function display();
}
