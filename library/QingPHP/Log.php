<?php
/**
 * 本类提供一个灵活的日志记录的实现
 *
 * 首先通过 QingPHP_Log::getLogger($config) 根据配置信息获取一个日志对象
 * QingPHP_Log::debug($message, ...) 进行日志记录
 * 通过配置文件可以灵活扩展日志的格式,和记录的后端(文件/mongodb/邮件等)
 * 配置文件数组 示例:
 * array ('name' => 'error' log标记
 * 'write' => '/tmp/myapp.log', 写入处理对象
 * 'level' => 3) 错误级别
 */
class QingPHP_Log
{
    /**
     * log级别
     */
    const EMERG   = 0;
    const ALERT   = 1;
    const CRIT    = 2;
    const ERROR   = 3;
    const WARN    = 4;
    const NOTICE  = 5;
    const INFO    = 6;
    const DEBUG   = 7;

    /**
     * level 用以支持常量的转化
     *
     * @static
     * @var string
     * @access public
     */
    static $level = array('EMERG', 'ALERT', 'CRIT', 'ERROR', 'WARN', 'NOTICE', 'INFO', 'DEBUG');

    private $config;
    private static $instances = array();

    /**
     * 构造函数,不允许直接实例化
     *
     * @param array $config
     * @access protected
     * @return QingPHP_Log
     */
    protected function __construct($config)
    {
        $this->config = $config;
    }

    /**
     * 获取log实例
     *
     * @param array $config
     * @static
     * @access public
     * @return QingPHP_Log
     */
    public static function getLogger()
    {
        $config = QingPHP_Config::instance()->get('log');

        /**
         *  查看$instances中是否已经存放了我们需要的logger的静态变量
         */
        $name = $config['name'];
        if (!isset(self::$instances[$name])) {
            /**
             * 这里实际上实例化了QingPHP_Log类本身的一个对象，logger既是QingPHP_Log对象
             * 在这次实例化了该对象，并放入$instances后，下次再需要这个logger时
             * 只需要从$instances中取出即可
             */
            self::$instances[$name] = new self($config);
        }

        return self::$instances[$name];
    }

    /**
     * 记录debug级别的日志
     *
     * @param string $message
     * @access public
     * @return void
     */
    public function debug($message)
    {
        /**
         * 使用反射方法
         * 提取出这个函数获得的参数，即错误信息格式、错误信息,
         * "phpexception:code:%d\nmessage:%s\nfile:%s:%d\ntrace:%s", 
         * $e->getCode(), $e->getMessage(), $e->getFile(), $e->getLine(), $e->getTraceAsString()
         * 在参数数组的第一个位置加入错误级别，即self::ERROR
         * 调用自己本身的log函数，将数组信息提交给log函数
         */
        $method = new ReflectionMethod($this, 'log');
        $args = func_get_args();
        array_unshift($args, self::DEBUG);
        $method->invokeArgs($this, $args);
    }

    /**
     * 记录notice级别的日志
     *
     * @param string $message
     * @access public
     * @return void
     */
    public function notice($message)
    {
        $method = new ReflectionMethod($this, 'log');
        $args = func_get_args();
        array_unshift($args, self::NOTICE);
        $method->invokeArgs($this, $args);
    }

    /**
     * 记录warn级别的日志
     *
     * @param string $message
     * @access public
     * @return void
     */
    public function warn($message)
    {
        $method = new ReflectionMethod($this, 'log');
        $args = func_get_args();
        array_unshift($args, self::WARN);
        $method->invokeArgs($this, $args);
    }

    /**
     * 记录error级别的日志
     *
     * @param string $message
     * @access public
     * @return void
     */
    public function error($message)
    {
        $method = new ReflectionMethod($this, 'log');
        $args = func_get_args();
        array_unshift($args, self::ERROR);
        $method->invokeArgs($this, $args);
    }


    /**
     * 写入函数处理, 以上常用级别的日志记录都是实际的执行方法
     * 可变参数支持vsprintf方式修饰message
     *
     * @param intval $level
     * @param string $message
     * @access public
     * @return void
     */
    public function log($level, $message)
    {
        if ($level > $this->config['level']) {
            return false;
        }

        /**
         *  如果参数大于2个，则截取前2个以外的参数
         */
        if (func_num_args() > 2) {
            $allArgs = func_get_args();
            $args = array_splice($allArgs, 2);
        } else {
            $args = array();
        }

        /**
         * 格式化日志信息
         */
        $str = '';
        if (!isset($this->config['handle']) || $this->config['handle'] == 'default') {
            $str .= '"' . date('Y-m-d H:i:s') . '" ' . $this->config['name'] . ' ' . self::$level[$level] . ' ';
            $str .= '"' . addslashes(isset($args) ? vsprintf($message, $args) : $message) . '"';
            $str .= "\n";
        } else {
            $str .= call_user_func_array($this->config['handle'] . '::format', array($this->config, $level, $message, $args));
        }

        /**
         * 写入的处理, 如果是php支持的流方式 php:// 和文件系统直接写入 如果是设置处理类直接调用
         */
        if (!isset($this->config['write'])) {
            var_dump($str);
        } elseif (preg_match("/^php:\/\/|\//", $this->config['write'])) {
            file_put_contents($this->config['write'], $str, FILE_APPEND);
        } else {
            $str = call_user_func_array($this->config['write'] . '::write', array($this->config, $str));
        }
    }
}
