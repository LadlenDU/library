<?php

namespace app\core\db;

use app\helpers\Helper;

class DbPDO implements \app\base\IDatabase
{
    /** @var \PDO соединение */
    protected $pdo;

    /** @var array Подстановочные значения. */
    //protected $subst = [];

    /** @var string Генерируемая строка SQL. */
    //protected $sqlString = '';

    public function __construct()
    {
        //$this->clear();

        $connect = \app\core\Config::inst()->database['connection'];

        $dsn = "mysql:host={$connect['host']};dbname={$connect['dbname']};charset={$connect['charset']}";
        $opt = array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        );

        $this->pdo = new \PDO($dsn, $connect['user'], $connect['password'], $opt);
    }

    /*public function clear()
    {
        $this->subst = [];
        $this->sqlString = '';
    }*/

    /**
     * @inheritdoc
     */
    public function quote($val)
    {
        return $this->pdo->quote($val);
    }

    /**
     * @inheritdoc
     */
    public function quoteName($name)
    {
        return '`' . str_replace('`', '``', $name) . '`';
    }

    /**
     * @inheritdoc
     */
    public function rawSelectQuery($sql, $values = [])
    {
        $res = [];

        $sth = $this->pdo->prepare($sql);
        if ($sth->execute($values))
        {
            $res = $sth->fetchAll();
        }

        /*$stmt = $this->pdo->query($sql);
        while ($row = $stmt->fetch())
        {
            $res[] = $row['name'];
        }*/

        return $res;
    }

    /*protected function sqlFields($fields)
    {
        $ret = ($fields == '*') ? $fields : '`' . implode('`, `', $fields) . '`';
        return $ret;
    }*/

    /*protected function sqlWhere($where)
    {
        $retSql = '';
        $retParams = [];

        $i = 0;
        foreach ($where as $el)
        {
            $pdoName = ':' . $el[0] . '_' . ++$i;
            $retSql .= "`$el[0]` $el[1] $pdoName AND ";
            $retParams[$pdoName] = $el[2];
        }
        $retSql = substr($retSql, 0, -5); // trim ' AND '

        return ['sql' => ' ' . $retSql . ' ', 'params' => $retParams];
    }*/

    //TODO: вынести в родительский
    /*public function insert($table, $fields)
    {
        $sql = "INSERT INTO `$table` SET ";
        $i = 0;
        foreach ($fields as $el)
        {
            $pdoName = ':' . $el[0] . '_' . ++$i;
            $sql .= "$el = $pdoName, ";
        }
        $sql = substr($sql, 0, -2); // trim ', '
    }*/

    //TODO: вынести в родительский
    /*public function select($table, $fields = '*', $where = [])
    {
        $res = [];
        $wParams = [];

        $sql = 'SELECT ' . $this->sqlFields($fields) . " FROM `$table` ";
        if ($where)
        {
            list($wSql, $wParams) = $this->sqlWhere($where);
            $sql .= ' WHERE ' . $wSql;
        }

        $sth = $this->pdo->prepare($sql);
        if ($sth->execute($wParams))
        {
            $res = $sth->fetchAll();
        }

        return $res;
    }*/

    /**
     * @inheritdoc
     */
    public function rawQuery($sql, $values = [], $valuesBlob = [])
    {
        $sth = $this->pdo->prepare($sql);

        if ($valuesBlob)
        {
            foreach ($valuesBlob as $fldName => $filePath)
            {
                $fContent = file_get_contents($filePath);
                $sth->bindParam(
                    $fldName,
                    $fContent,
                    \PDO::PARAM_LOB,
                    0,
                    \PDO::SQLSRV_ENCODING_BINARY
                );
            }
        }

        //$preparedQueries[$sql] = $sth;

        //$this->pdo->errorInfo();

        $state = $sth->execute($values);

        return $state;
    }

    /**
     * @inheritdoc
     */
    public function beginTransaction()
    {
        return $this->pdo->beginTransaction();
    }

    /**
     * @inheritdoc
     */
    public function commitTransaction()
    {
        return $this->pdo->commit();
    }

    /**
     * @inheritdoc
     */
    public function rollbackTransaction()
    {
        return $this->pdo->rollBack();
    }

    /**
     * @inheritdoc
     */
    public function getTextColumnMaximumLength($table, $columns)
    {
        assert($columns);

        $columns = (array)$columns;

        $cond = implode(', :col_', $columns);
        $sql = 'SELECT `COLUMN_NAME`, `CHARACTER_MAXIMUM_LENGTH` FROM `INFORMATION_SCHEMA`.`COLUMNS`'
            . ' WHERE `TABLE_SCHEMA` = Database() '
            . ' AND `TABLE_NAME` = :tblName '
            . " AND `COLUMN_NAME` IN (:col_$cond)";

        $queryValues[':tblName'] = $table;
        foreach ($columns as $col)
        {
            $queryValues[':col_' . $col] = $col;
        }

        return $this->rawSelectQuery($sql, $queryValues);
    }

    public function lastInsertId()
    {
        return $this->pdo->lastInsertId();
    }

    /**
     * @inheritdoc
     *
     * public function multipleQuery($sql, $values = [])
     * {
     * $sth = $this->pdo->prepare($sql);
     * if ($state = $sth->execute($values))
     * {
     * $state->closeCursor();
     * }
     *
     * return $state;
     * }*/
}