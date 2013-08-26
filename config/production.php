<?php
/**
 * config 配置
 */
$config = array();
$config['environment'] = $environment;

/**
 * include_path 加载目录
 */
$config['include_path'] = get_include_path() . PATH_SEPARATOR . 
    implode(PATH_SEPARATOR, array(LIB_PATH, APP_PATH, APP_CTLS, APP_MODLES));

/**
 * 默认时区
 */
$config['default_timezone'] = 'Asia/ShangHai';

/**
 * 默认控制器
 */
$config['default_c'] = 'Index';
$config['default_a'] = 'empty';

/**
 * db 数据库配置
 */
$config['db'] = 'mysql://root:@127.0.0.1:3306?dbname=test';

/**
 * 输出设置
 */
$config['response']['default'] = 'html';
$config['response']['allow_format'] = true;

/**
 * 模板文件扩展名
 */
$config['tpl_extention'] = '.html';

/**
 * smarty 模板配置
 */
$config['smarty']['left_delimiter']  = '{{';
$config['smarty']['right_delimiter'] = '}}';
$config['smarty']['template_dir']    = APP_PATH . 'templates/';
$config['smarty']['compile_dir']     = CACHE_PATH . 'templates_c/';

/**
 * log 记录
 */
$config['log']['name'] = 'error_log';                                                  
$config['log']['write'] = CACHE_PATH . 'log/error.log';                                                
$config['log']['level'] = 6;                                                 
