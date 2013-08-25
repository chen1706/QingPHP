<?php
/**
 * QingPHP_Db 
 * 
 * @uses PDO
 * @author chen1706 <chen1706@gmail.com> 
 */
final class QingPHP_Db extends PDO
{
    private $dsn;
    private static $instances = array();

    /**
     * 构造函数 一般情况不建议直接调用 使用QingPHP_Db::getInstance进行调用
     * 
     * @param string $dsn
     * @access public
     * @return QingPHP_Db
     */
    public function __construct($dsn)
    {
        $this->dsn = $dsn;
        $temp = parse_url($dsn);
        if ($temp['scheme'] == 'mysql') {
            parse_str($temp['query'], $query);
            $user = isset($temp['user']) ? $temp['user'] : 'root';
            $pass = isset($temp['pass']) ? $temp['pass'] : '';
            $port = isset($temp['port']) ? $temp['port'] : '3306';
            $charset = isset($query['charset']) ? $query['charset'] : 'UTF-8';
            $str = 'mysql:dbname=' . $query['dbname'] . ';host=' . $temp['host'] . ';port=' . $port . ';charset=' . $charset;
            $options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
            $options[PDO::MYSQL_ATTR_USE_BUFFERED_QUERY] = true;
            parent::__construct($str, $user, $pass, $options);
        } else {
            parent::__construct($dsn);
        }
    }

    /**
     * getDsn 
     * 
     * @return void
     */
    public function getDsn()
    {
        return $this->dsn;
    }

    /**
     * 获取对象实例静态方法
     * 
     * @param string $dsn  例: tcp://localhost:6379?timeout=2
     * @static
     * @access public
     * @return QingPHP_Db
     */
    public static function instance($dsn)
    {
        if (!isset(self::$instances[$dsn])) {
            self::$instances[$dsn] = new self($dsn);
        }

        return self::$instances[$dsn];
    }

    /**
     * 根据变量数组组合sql复制语句, 传递支持的字段参数 $keys数组 和对应的值数组 $vals 返回组合好的sql赋值字段
     *
     * @param array $keys
     * @param array $vals
     * @static
     * @access public
     * @return string
     */
    public static function genSqlValueStr($keys, &$vals)
    {
        $columns = array();
        foreach ($keys as $key) {
            if (isset($vals[$key])) {
                $columns[] = '`' . $key . '`=:' .$key;
            }
        }
        return implode(',', $columns);
    }

    /**
     * 给变量绑定数据
     *
     * @param string $keys
     * @param string $vals
     * @static
     * @access public
     * @return void
     */
    public static function genBindValue(PDOStatement $sth, $keys, &$vals)
    {
        foreach ($keys as $key) {
            if (isset($vals[$key])) {
                $sth->bindValue(':' . $key, $vals[$key]);
            }
        }
    }
}
