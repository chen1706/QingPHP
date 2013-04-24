<?php
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

    public function query($query)
    {
        $this->queryString = $query;
        return $this->pdo->query($query);
    }

    public function exec($query)
    {
        $this->queryString = $query;
        return $this->pdo->exec($query);
    }

    public function quote($string, $paramtype = NULL)
    {
        return $this->pdo->quote($string, $paramtype);
    }

    protected function arrayQuote(array $array)
    {
        $temp = array();
        foreach ($array as $val) {
            $temp[] = is_int($val) ? $val : $this->pdo->quote($value);
        }
        return implode(',', $temp);
    }

    protected function innerConjunct($data, $conjunctor, $outerConjunctor)
    {
        $haystack = array();
        foreach ($data as $val) {
            $haystack[] = '(' . $this->dataImplode($val, $conjunctor) . ')';
        }
        return implode($outerConjunctor . ' ', $haystack);
    }

    protected function dataImplode($data, $conjunctor, $outerConjunctor = null)
    {
        $wheres = array();
        foreach ($data as $key => $val) {
            if (($key == 'AND' || $key == 'OR') && is_array($val)) {
                $wheres[] = 0 !== count(array_diff_key($val, array_keys(array_keys($val)))) ?
                    '(' . $this->dataImplode($val, ' ' . $key) . ')' :
                    '(' . $this->innerConjunct($val, ' ' . $key, $conjunctor) . ')';
            } else {
                preg_match('/([\w]+)(\[(\>|\>\=|\<|\<\=|\!|\<\>)\])?/i', $key, $match);
                if (isset($match[3])) {
                    if ($match[3] == '' || $match[3] == '!') {
                        $wheres[] = $match[1] . ' ' . $match[3] . '= ' . $this->quote($value);
                    } else {
                        if ($match[3] == '<>') {
                            if (is_array($val) && is_numeric($val[0]) && is_numeric($val[1])) {
                                $wheres[] = $match[1] . ' BETWEEN ' . $val[0] . ' AND ' . $val[1];
                            }
                        } else {
                            if (is_numeric($val)) {
                                $wheres[] = $match[1] . ' ' . $match[3] . ' ' . $val;
                            }
                        }
                    }
                } else {
                    if (is_int($key)) {
                        $wheres[] = $this->quote($val);
                    } else {
                        $wheres[] = is_array($val) ? $match[1] . ' IN (' . $this->arrayQuote($val) . ')' :
                            $match[1] . ' = ' . $this->quote($val);
                    }
                }
            }
        }
        return implode($conjunctor . ' ', $wheres);
    }

    public function whereClause($where)
    {
        $whereClause = '';
        if (is_array($where)) {
            $singleCondition = array_diff_key($where, array_flip(
                array('AND', 'OR', 'GROUP', 'ORDER', 'HAVING', 'LIMIT', 'LIKE', 'MATCH')
            ));
            if ($singleCondition != array()) {
                $whereClause = ' WHERE ' . $this->dataImplode($singleCondition, '');
            }
            if (isset($where['AND'])) {
                $whereClause = ' WHERE ' . $this->dataImplode($where['AND'], ' AND ');
            }
            if (isset($where['OR'])) {
                $whereClause = ' WHERE ' . $this->dataImplode($where['OR'], ' OR ');
            }
            if (isset($where['LIKE'])) {
                $likeQuery = $where['LIKE'];
                if (is_array($likeQuery)) {
                    if (isset($likeQuery['OR']) || isset($likeQuery['AND'])) {
                        $connector = isset($likeQuery['OR']) ? 'OR' : 'AND';
                        $like_query = isset($likeQuery['OR']) ? $likeQuery['OR'] : $likeQuery['AND'];
                    } else {
                        $connector = 'AND';
                    }
                    $clauseWrap = array();
                    foreach ($likeQuery as $column => $keyword) {
                        if (is_array($keyword)) {
                            foreach ($keyword as $key) {
                                $clauseWrap[] = $column . ' LIKE ' . $this->quote('%' . $key . '%');
                            }
                        } else {
                            $clauseWrap[] = $column . ' LIKE ' . $this->quote('%' . $keyword . '%');
                        }
                    }
                    $whereClause .= ($whereClause != '' ? ' AND ' : ' WHERE ') . '(' . implode($clauseWrap, ' ' . $connector . ' ') . ')';
                }
            }
            if (isset($where['MATCH'])) {
                $matchQuery = $where['MATCH'];
                if (is_array($matchQuery) && isset($matchQuery['columns']) && isset($matchQuery['keyword'])) {
                    $whereClause .= ($whereClause != '' ? ' AND ' : ' WHERE ') . ' MATCH (' . implode($matchQuery['columns'], ', ') . ') AGAINST (' . $this->quote($matchQuery['keyword']) . ')';
                }
            }
            if (isset($where['GROUP'])) {
                $whereClause .= ' GROUP BY ' . $where['GROUP'];
            }
            if (isset($where['ORDER'])) {
                $whereClause .= ' ORDER BY ' . $where['ORDER'];
                if (isset($where['HAVING'])) {
                    $whereClause .= ' HAVING ' . $this->dataImplode($where['HAVING'], '');
                }
            }
            if (isset($where['LIMIT'])) {
                if (is_numeric($where['LIMIT'])) {
                    $whereClause .= ' LIMIT ' . $where['LIMIT'];
                }
                if (is_array($where['LIMIT']) && is_numeric($where['LIMIT'][0]) && is_numeric($where['LIMIT'][1])) {
                    $where_clause .= ' LIMIT ' . $where['LIMIT'][0] . ',' . $where['LIMIT'][1];
                }
            }
        } else {
            if ($where != null) {
                $whereClause .= ' ' . $where;
            }
        }

        return $whereClause;
    }

    public function select($table, $columns, $where = null) 
    {
        if (is_callable($where) && $callback == null) {
            $callback = $where;
            $where = '';
        }

        $query = $this->query('SELECT ' . (
            is_array($columns) ? implode(', ', $columns) : $columns
        ) . ' FROM ' . $table . $this->whereClause($where));

        return $query ? $query->fetchAll(
            (is_string($columns) && $columns != '*') ? PDO::FETCH_COLUMN : PDO::FETCH_ASSOC
        ) : false;
    }

    public function insert($table, $data)
    {
        $keys = implode(',', array_keys($data));
        $values = array();
        foreach ($data as $key => $val) {
            $values[] = is_array($val) ? serialize($val) : $value;
        }
        $this->query('INSERT INTO ' . $table . ' (' . $keys . ') VALUES (' . $this->dataImplode(array_values($values), ',') . ')');
        return $this->pdo->lastInsertId();
    }

    public function update($table, $data, $where = null)
    {
        $fields = array();
        foreach ($data as $key => $val) {
            if (is_array($val)) {
                $fields[] = $key . '=' . $this->quote(serialize($val));
            } else {
                preg_match('/([\w]+)(\[(\+|\-)\])?/i', $key, $match);
                if (isset($match[3])) {
                    if (is_numeric($val)) {
                        $fields[] = $match[1] . ' = ' . $match[1] . ' ' . $match[3] . ' ' . $val;
                    }
                } else {
                    $fields[] = $key . ' = ' . $this->quote($val);
                }
            }
        }        
        return $this->exec('UPDATE ' . $table . ' SET ' . implode(',', $fields) . $this->whereClause($where));
    }

    public function delete($table, $where)
    {
        return $this->exec('DELETE FROM ' . $table . $this->whereClause($where));
    }

    public function replace($table, $columns, $search = null, $replace = null, $where = null)
    {
        if (is_array($columns)) {
            $replaceQuery = array();
            foreach ($columns as $column => $replacements) {
                foreach ($replacements as $replaceSearch => $replaceReplacement) {
                    $replaceQuery[] = $column . ' = REPLACE(' . $column . ', ' . $this->quote($replaceSearch) . ', ' . $this->quote($replaceReplacement) . ')';
                }
            }
            $replaceQuery = implode(', ', $replaceQuery);
            $where = $search;
        } else {
            if (is_array($search)) {
                $replaceQuery = array();
                foreach ($search as $replaceSearch => $replaceReplacement) {
                    $replaceQuery[] = $columns . ' = REPLACE(' . $columns . ', ' . $this->quote($replaceSearch) . ', ' . $this->quote($replaceReplacement) . ')';
                }
                $replace_query = implode(', ', $replaceQuery);
                $where = $replace;
            } else {
                $replaceQuery = $columns . ' = REPLACE(' . $columns . ', ' . $this->quote($search) . ', ' . $this->quote($replace) . ')';
            }
        }
        return $this->exec('UPDATE ' . $table . ' SET ' . $replaceQuery . $this->whereClause($where));
    }

    public function get($table, $columns, $where = null)
    {
        if (is_array($where)) {
            $where['LIMIT'] = 1;
        }
        $data = $this->select($table, $columns, $where);
        return isset($data[0]) ? $data[0] : false;
    }

    public function has($table, $where)
    {
        return $this->query('SELECT EXISTS(SELECT 1 FROM ' . $table . $this->whereClause($where) . ')')->fetchColumn() === '1';
    }

    public function count($table, $where = null)
    {
        return 0 + ($this->query('SELECT COUNT(*) FROM ' . $table . $this->whereClause($where))->fetchColumn());
    }

    public function max($table, $column, $where = null)
    {
        return 0 + ($this->query('SELECT MAX(' . $column . ') FROM ' . $table . $this->whereClause($where))->fetchColumn());
    }

    public function min($table, $column, $where = null)
    {
        return 0 + ($this->query('SELECT MIN(' . $column . ') FROM ' . $table . $this->whereClause($where))->fetchColumn());
    }

    public function avg($table, $column, $where = null)
    {
        return 0 + ($this->query('SELECT AVG(' . $column . ') FROM ' . $table . $this->whereClause($where))->fetchColumn());
    }

    public function sum($table, $column, $where = null)
    {
        return 0 + ($this->query('SELECT SUM(' . $column . ') FROM ' . $table . $this->whereClause($where))->fetchColumn());
    }

    public function error()
    {
        return $this->pdo->errorInfo();
    }

    public function lastQuery()
    {
        return $this->queryString;
    }

    public function version()
    {
        return $this->pdo->getAttribute(PDO::ATTR_SERVER_VERSION);
    }

    public function info()
    {
        return $this->pdo->getAttribute(PDO::ATTR_SERVER_INFO);
    }
}
