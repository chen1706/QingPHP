<?php
/**
 * QingPHP_Route_Interface 接口 
 * 
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
interface QingPHP_Route_Interface
{
	public function route(QingPHP_Request_Abstract $request);
}
