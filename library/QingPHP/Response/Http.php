<?php
/**
 * QingPHP_Response_Http 
 * 
 * @uses QingPHP
 * @uses _Response_Abstract
 * @final
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
final class QingPHP_Response_Http extends QingPHP_Response_Abstract
{
	protected $code = 0;

    /**
     * response 
     * 
     * @access public
     * @return void
     */
	public function response()
	{
		/**
		 * 输出格式判定优先级
		 * 1. 客户端参数指定
		 * 2. action指定
		 * 3. http请求Accept头信息 
		 * 4. 对应请求类型指定默认
		 * 5. 默认输出格式
		 */
		$formatConfig = QingPHP_Config::instance()->get('response');

		/**
		 * 输出格式列表
		 */
		$formatList = array(
				QingPHP_Const::FT_JSON,
				QingPHP_Const::FT_XML,
				QingPHP_Const::FT_TEXT,
				QingPHP_Const::FT_SERIAL,
				QingPHP_Const::FT_BINARY
			);
		$request = QingPHP_Registry::get('request');
		if ($formatConfig['allow_format'] && $request->get('format') 
			&& in_array($request->get('format'), $formatList)) {
			$format = $request->get('format');
		} else {
			$format = $formatConfig['default'];
		}

		/**
		 * 根据不同格式 做输出处理 
		 */
		switch ($format) {
			case QingPHP_Const::FT_JSON:
				return $this->responseJson();
			case QingPHP_Const::FT_XML:
				return $this->responseXml();
			case QingPHP_Const::FT_TEXT:
				return $this->responseText();
			case QingPHP_Const::FT_SERIAL:
				return $this->responseSerial();
			case QingPHP_Const::FT_BINARY:
				return $this->responseBinary();
			default :
				throw new QingPHP_Exception('output format error' . $format, 500);
		}
	}

    /**
     * responseJson 
     * 
     * @access protected
     * @return void
     */
	protected function responseJson()
	{
		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode($this->getInterfaceData());
	}

    /**
     * getInterfaceData 
     * 
     * @access private
     * @return void
     */
	private function getInterfaceData()
	{
		if (0) {
		} else {
			$response = implode('', $this->body);
			return array('errcode' => 0, 'message' => $response);
		}
	}
}
