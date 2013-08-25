<?php
/**
 * 设置环境变量
 */
define('ROOT_PATH',  dirname(__DIR__)); //根目录                                 
define('CNF_PATH',   ROOT_PATH . '/config/'); //配置文件
define('LIB_PATH',   ROOT_PATH . '/library/'); //系统类库 
//app目录 admin的可以另起 global 配置文件
define('APP_PATH',   ROOT_PATH . '/application/'); 
define('APP_CTLS',   APP_PATH  . '/controllers/'); 
define('APP_MODLES', APP_PATH  . '/models/'); 

$environment = 'development';
return include_once $environment . '.php';                       
