<?php
chdir(dirname(__DIR__));
include './config/global.php';
include './library/QingPHP.php';

/**
 * 框架创建app 开始执行
 */
QingPHP::createApp($config)
    ->run();