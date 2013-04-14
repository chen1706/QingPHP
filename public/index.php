<?php
include_once '/home/chen1706/opt/xhprof-master/xhprof_lib/utils/xhprof_lib.php';
include_once '/home/chen1706/opt/xhprof-master/xhprof_lib/utils/xhprof_runs.php';
xhprof_enable(XHPROF_FLAGS_CPU + XHPROF_FLAGS_MEMORY);

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
$xhprof_data = xhprof_disable(); 
$xhprof_runs = new XHProfRuns_Default(); 
$run_id = $xhprof_runs->save_run($xhprof_data, 'xhprof_foo');
echo "性能报告地址====<a target='_blank' href=http://qingphp.vps:88/xhprof_html/index.php?run=$run_id&source=xhprof_foo>点击查看报告</a>";
