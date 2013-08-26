<?php /* Smarty version Smarty-3.1.13, created on 2013-08-26 15:44:02
         compiled from "/home/chen1706/git/QingPHP/application/templates/hello.html" */ ?>
<?php /*%%SmartyHeaderCode:337506199521b0742d61885-86715820%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '67e51e6b5db3276822a7dbf946e7fe5a8ca81413' => 
    array (
      0 => '/home/chen1706/git/QingPHP/application/templates/hello.html',
      1 => 1377436092,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '337506199521b0742d61885-86715820',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'username' => 0,
    'cost_time' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.13',
  'unifunc' => 'content_521b0742db34d2_23910303',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_521b0742db34d2_23910303')) {function content_521b0742db34d2_23910303($_smarty_tpl) {?><!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Welcome to QingPHP</title>
<style type="text/css">
::selection{ background-color: #E13300; color: white; }
::moz-selection{ background-color: #E13300; color: white; }
::webkit-selection{ background-color: #E13300; color: white; }
body {
    background-color: #fff;
    margin: 40px;
    font: 13px/20px normal Helvetica, Arial, sans-serif;
    color: #4F5155;
}
a {
    color: #003399;
    background-color: transparent;
    font-weight: normal;
}
h1 {
    color: #444;
    background-color: transparent;
    border-bottom: 1px solid #D0D0D0;
    font-size: 19px;
    font-weight: normal;
    margin: 0 0 14px 0;
    padding: 14px 15px 10px 15px;
}
code {
    font-family: Consolas, Monaco, Courier New, Courier, monospace;
    font-size: 12px;
    background-color: #f9f9f9;
    border: 1px solid #D0D0D0;
    color: #002166;
    display: block;
    margin: 14px 0 14px 0;
    padding: 12px 10px 12px 10px;
}
#body{
    margin: 0 15px 0 15px;
}
p.footer{
    text-align: right;
    font-size: 11px;
    border-top: 1px solid #D0D0D0;
    line-height: 32px;
    padding: 0 10px 0 10px;
    margin: 20px 0 0 0;
}
#container{
    margin: 10px;
    border: 1px solid #D0D0D0;
    -webkit-box-shadow: 0 0 8px #D0D0D0;
}
</style>
</head>
<body>
    <div id="container">
        <h1>Welcome to QingPHP <?php echo $_smarty_tpl->tpl_vars['username']->value;?>
 !</h1>
        <div id="body">
            <p>The page you are looking at is being generated dynamically by QingPHP.</p>
            <p>The corresponding controller for this page is found at:</p>
            <code>application/controllers/IndexController.php</code>
        </div>
        <p class="footer">Page rendered in <strong><?php echo $_smarty_tpl->tpl_vars['cost_time']->value;?>
</strong> seconds</p>
    </div>
</body>
</html>
<?php }} ?>