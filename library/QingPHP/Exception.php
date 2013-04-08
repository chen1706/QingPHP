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
abstract class QingPHP_Exception extends Exception
{    
    public function __construct(string $message, int $code = 500)
    {
        parent::__construct($message, $code);
    }
}
