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
    protected $header = array();

    /**
     *  输出的内容变量数组
     */
    protected $response = array();

    /**
     * 只传递给smarty的变量集合 不进行接口输出
     */
    protected $autoResponse = array();

    public function setResponse($key, $val = null, $auto = false)
    {
        if (func_num_args() == 1) {
            $this->response = $key;
        } else {
            $auto ? $this->autoResponse[$key] = $val : $this->response[$key] = $val;
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

    public function getHeader()
    {
        return $this->header;
    }

    abstract public function display();
}
