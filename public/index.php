<?php
/**
 * 进入程序根目录
 */
chdir(dirname(__DIR__));
include './config/global.php';
include './library/QingPHP.php';

define('START_TIME', microtime(true));

/**
 * 框架创建app 开始执行
 */
QingPHP::createApp($config)
    ->run();
echo microtime(true) - START_TIME;
