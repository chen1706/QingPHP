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
    private $tplFile = null;
    /**
     * response 
     * 
     * @access public
     * @return void
     */
	public function display($tpl = null)
    {
        $this->tplFile = $tpl;
        /** 
         * 如果有设置输出头 则输出
         */
        $this->outputHeader();

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
                QingPHP_Const::FT_HTML,
                QingPHP_Const::FT_XHTML,
				QingPHP_Const::FT_JSON,
				QingPHP_Const::FT_XML,
				QingPHP_Const::FT_TEXT,
				QingPHP_Const::FT_SERIAL,
				QingPHP_Const::FT_BINARY
			);

		$request = QingPHP_Registry::get('request');
        $outFormat = QingPHP_Registry::get('out_format');

		if ($formatConfig['allow_format'] && $request->get('format') 
			&& in_array($request->get('format'), $formatList)) {
			$format = $request->get('format');
		} elseif ($outFormat) {
            $format = $outFormat;
        } else {
			$format = $formatConfig['default'];
        }

		/**
		 * 根据不同格式 做输出处理 
		 */
        switch ($format) {
            case QingPHP_Const::FT_HTML:
                return $this->outputHtml();
            case QingPHP_Const::FT_XHTML:
                return $this->outputXhtml();
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
     * outputHtml 
     * 
     * @access protected
     * @return void
     */
    protected function outputHtml()
    {
        header('Content-Type: text/html; charset=UTF-8');
        $this->outputCommon(QingPHP_Const::FT_HTML);
    }

    protected function outputCommon($format)
    {
        $tpl = new QingPHP_View(QingPHP_Config::instance()->get('smarty'));
        if ($this->tplFile) {
            $this->_display($tpl, $format);
        } else {
            $response = $this->getResponse();
            if (is_string($response)) {
                echo $response;
            } else {
                echo "<pre>\n";
                var_export($response);
                echo "</pre>\n";
            }
        }
    }

    private function _display(QingPHP_View $tpl, $format)
    {
        $response = $this->getResponse();
        is_array($response) || $response = array('result' => $response);
        foreach ($response as $key => $val) {
            $tpl->assign($key, $val);
        }
        //autoResponse 
        $autoResponse = $this->getResponse(true);
        if (is_array($autoResponse)) {
            foreach ($autoResponse as $key => $val) {
                $tpl->assign($key, $val);
            }
        }
        $file = $this->tplFile . '.' . $format;
        $tpl->display($file);
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
			return array('errcode' => 0, 'message' => $this->getResponse());
		}
	}

    protected function outputHeader()
    {
        $header = $this->getHeader();
        if (is_array($header)) {
            foreach ($header as $val) {
                header($val);
            }
        }
    }
}
