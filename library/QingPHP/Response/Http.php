<?php
/**
 * QingPHP_Response_Http 
 * 
 * @uses QingPHP_Response_Abstract
 * @final
 * @package package
 * @version $Id$
 * @copyright ©2013
 * @author chen1706 <chen1706@gmail.com> 
 * @license New BSD License
 */
final class QingPHP_Response_Http extends QingPHP_Response_Abstract
{
    /**
     * 模板文件
     */
    private $tplFile = null;

    /**
     * response 
     * 
     * @access public
     * @return void
     */
	public function display($tpl = null)
    {
        ob_start();
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
        $formatList = array();
        $formatList[] = QingPHP_Const::FT_HTML; 
        $formatList[] = QingPHP_Const::FT_XHTML; 
        $formatList[] = QingPHP_Const::FT_JSON; 
        $formatList[] = QingPHP_Const::FT_XML; 
        $formatList[] = QingPHP_Const::FT_TEXT; 
        $formatList[] = QingPHP_Const::FT_SERIAL; 
        $formatList[] = QingPHP_Const::FT_BINARY; 

		$request   = QingPHP_Registry::get('request');
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
                return $this->responseHtml();
            case QingPHP_Const::FT_XHTML:
                return $this->responseXhtml();
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
        ob_end_flush();
        ob_end_clean();
	}

    /**
     * responseHtml 
     * 
     * @access protected
     * @return void
     */
    protected function responseHtml()
    {
        header('Content-Type: text/html; charset=UTF-8');
        $this->responseCommon(QingPHP_Const::FT_HTML);
    }
    
    /**
     * responseXhtml 输出xhtml wap2.0的格式
     *
     * @return void
     */
    protected function responseXhtml()
    {
        header("Content-Type: application/xhtml+xml; charset=UTF-8");
        $this->responseCommon(QingPHPConst::FT_XHTML);
    }

    /**
     * responseWml 输出wml
     *
     * @return void
     */
    protected function responseWml()
    {
        header("Content-Type: text/vnd.wap.wml; charset=UTF-8");
        $this->responseCommon(QingPHPConst::FT_WML);
    }

    /**
     * responseJson
     *
     * @return void
     */
    protected function responseJson()
    {
        header("Content-Type: application/json; charset=UTF-8");
        echo json_encode($this->getInterfaceData());
    }

    /**
     * responseXml
     *
     * @return void
     */
    protected function responseXml()
    {
        header("Content-Type: text/xml; charset=UTF-8");
        echo self::toXml($this->getInterfaceData());
    }

    /**
     * responseText
     *
     * @return void
     */
    protected function responseText()
    {
        header("Content-Type: text/plain; charset=UTF-8");
        echo "<pre>\n";
        var_export($this->getInterfaceData());
        echo "</pre>\n";
    }

    /**
     * responseSerial
     *
     * @return void
     */
    protected function responseSerial()
    {
        header("Content-Type: text/plain; charset=UTF-8");
        echo serialize($this->getInterfaceData());
    }

    /**
     * responseBinary 输出二进制内容
     *
     * @return void
     */
    protected function responseBinary()
    {
        echo $this->getResponse();
    }

    /**
     * responseCommon 
     * 
     * @param mixed $format format 
     * 
     * @return void
     */
    protected function responseCommon($format)
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

    /**
     * _display 
     * 
     * @param QingPHP_View $tpl tpl 
     * @param mixed $format format 
     * 
     * @return void
     */
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

    /**
     * outputHeader 
     * 输出header 
     * 
     * @return void
     */
    protected function outputHeader()
    {
        $header = $this->getHeader();
        if (is_array($header)) {
            foreach ($header as $val) {
                header($val);
            }
        }
    }

    /**
     * toXml 生成xml数据 
     * 
     * @param mixed $data data 
     * @param string $rootNodeName rootNodeName 
     * @param mixed $xml xml 
     * 
     * @return void
     */
    public static function toXml($data, $rootNodeName = 'root', $xml = null)
    {
        $xml == null && $xml = simplexml_load_string("<$rootNodeName />");
        foreach ($data as $key => $val) {
            if (is_numeric($key)) {
                $key = "node";
            }
            if (is_array($val)) {
                $node = $xml->addChild($key);
                self::toXml($val, $rootNodeName, $node);
            } else {
                $val = htmlentities($val);
                $xml->addChild($key, $val);
            }
        }
        return $xml->asXML();
    }
}
