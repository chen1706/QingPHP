<?php
/**
 * 定义app路径
 */
define('ROOT_PATH', dirname(__DIR__));

$config = array();
$config['library_directory'] = ROOT_PATH . '/library/';
$config['application_directory'] = ROOT_PATH . '/application/';
$config['controller_directory'] = $config['application_directory'] . '/controllers/';
$config['model_directory'] = $config['application_directory'] . '/models/';

/**
 * include_path 加载目录
 */
$config['include_path_arr']['app_controller'] = $config['controller_directory'];
$config['include_path_arr']['app_model'] = $config['model_directory'];
$config['include_path_arr']['library'] = $config['library_directory'];
$config['include_path'] = implode(PATH_SEPARATOR, $config['include_path_arr']);
unset($config['include_path_arr']);

/**
 * 默认时区
 */
$config['default_timezone'] = 'Asia/ShangHai';

/**
 * 默认控制器
 */
$config['default_controller'] = 'Index';
$config['default_action'] = 'index';

/**
 * db 数据库配置
 */
$config['pdo'] = 'mysql://root:@127.0.0.1:3306?dbname=test';

/**
 * 输出设置
 */
$config['response']['default'] = 'json';
$config['response']['allow_format'] = true;

/**
 * smarty 模板配置
 */
$config['smarty']['left_delimiter'] = '<{';
$config['smarty']['right_delimiter'] = '}>';
$config['smarty']['template_dir'] = $config['application_directory'] . 'templates/';
$config['smarty']['compile_dir'] = $config['application_directory'] . 'templates_c/';
$config['smarty']['cache_dir'] = $config['application_directory'] . 'templates_d/';