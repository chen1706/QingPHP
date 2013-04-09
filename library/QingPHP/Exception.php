<?php
/**
 * QingPHP_Exception 
 * 
 * @uses Exception
 * @abstract
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
class QingPHP_Exception extends Exception
{    
    public function __construct($message, $code = 500)
    {
        parent::__construct($message, $code);
    }

    public static function showException(Exception $e)
    {
        $trace = '';
        foreach ($e->getTrace() as $key => $val) {
            $str = '<p>';
            $str = 'File: ' . $val['file'] . ' ';
            $str .= '<strong><font color="#002166">+' . $val['line'] . '</font></strong> ';
            $str .= '' . $val['class'] . $val['type'] . $val['function'];
            $str .= '</p>';
            $trace .= $str;
        }

        $content = sprintf('
            <p>Message: %s </p>
            <code>Filename: %s </code>
            <p>Line Number: %s </p>
            <p>%s </p>', $e->getMessage(), $e->getFile(), $e->getLine(), $trace);
        showException($content, $trace);
    }
}

function showException($content)
{
    echo <<<EOF
    <!DOCTYPE html>
    <html>
    <head>
    <meta charset="utf-8">
    <title>A PHP Error was encountered !</title>
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
            <h1>A PHP Error was encountered ! </h1>
            <div id="body">
                $content
            </div>
           <p class="footer">Page rendered exception</p> 
        </div>
    </body>
    </html>
EOF;
}
