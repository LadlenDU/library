<?php

namespace app\models;

use app\base\Model;
use app\core\Container;
use app\core\Web;
use app\models\Language;

/**
 * User модель пользователя.
 *
 * @package app\models
 */
class User extends Model
{
    /** Поля, которые необходимо обрезать методом trim() перед сохранением. */
    protected static $toTrim = ['login', 'first_name', 'last_name', 'email', 'phone_mobile', 'address'];

    /** @var int Идентификатор пользователя. */
    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
        parent::__construct();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => _('ID'),
            'login' => _('Login'),
            'first_name' => _('First name'),
            'last_name' => _('Last name'),
            'email' => _('E-mail'),
            'phone_mobile' => _('Phone'),
            'birthday' => _('Birthday'),
            'gender' => _('Gender'),
            'country_code' => _('Country'),
            'address' => _('Address'),
            'image' => _('Image'),
        ];
    }

    public function attributeLabelsColon()
    {
        return [
            'id' => _('ID:'),
            'login' => _('Login:'),
            'first_name' => _('First name:'),
            'last_name' => _('Last name:'),
            'email' => _('E-mail:'),
            'phone_mobile' => _('Phone:'),
            'birthday' => _('Birthday:'),
            'gender' => _('Gender:'),
            'country_code' => _('Country:'),
            'address' => _('Address:'),
            'image' => _('Image:'),
        ];
    }

    /**
     * Возвращает информацию о всех пользователях.
     *
     * @param string $fields Список полей для выборки.
     * @return array
     */
    public function getUsers($fields = ['id', 'login', 'first_name', 'last_name', 'email'])
    {
        $q = 'SELECT' . (($fields == '*') ? ' * ' : (' `' . implode('`, `', (array)$fields) . '` '))
            . 'FROM `user` WHERE ' . $this->sqlWhereNotDeleted();

        $res = $this->db->rawSelectQuery($q);

        return $res;
    }

    /**
     * Возвращает информацию о пользователе.
     *
     * @param int $id Идентфикатор пользователя.
     * @param string $fields Список полей для выборки.
     * @param bool $markImageIfExist Возвращать ли признак наличия изображения
     * ('not_exists' или 'exists') вместо данных изображения.
     * @return string[]
     */
    public function getInfo($id, $fields = '*', $markImageIfExist = true)
    {
        $fieldsSql = '';

        if ($fields == '*')
        {
            //TODO: проверить работу такого запроса на оптимальность
            $fieldsSql = '`u`.*';
            if ($markImageIfExist)
            {
                $fieldsSql .= ', ' . $this->sqlFieldEmptyToken('image', 'u') . ', '
                    . $this->sqlFieldEmptyToken('image_thumb', 'u');
            }
        }
        else
        {
            $fields = (array)$fields;

            if ($markImageIfExist)
            {
                foreach ($fields as $fld)
                {
                    $fieldsSql .= (($fld == 'image' || $fld == 'image_thumb')
                            ? $this->sqlFieldEmptyToken($fld, 'u')
                            : $this->db->quoteName($fld)) . ', ';
                }

                $fieldsSql = substr($fieldsSql, 0, -2); // remove ', '
            }
            else
            {
                array_walk(
                    $fields,
                    function (&$val)
                    {
                        $val = $this->db->quoteName($val);
                    }
                );
                $fieldsSql = implode(', ', $fields);
            }
        }

        $params = [':id' => $id];

        $link = '';
        if ($fields == '*' || in_array('country_code', $fields))
        {
            $link = 'LEFT JOIN `country` AS `c` ON `c`.`code` = `u`.`country_code` AND `c`.`language_code` = :language_code';
            $params[':language_code'] = Language::getLanguage();
            $fieldsSql .= ', `c`.`name` AS `country_name`';
        }

        $q = "SELECT $fieldsSql FROM `user` AS `u` $link WHERE `id` = :id AND "
            . $this->sqlWhereNotDeleted('u') . " LIMIT 1";

        if ($res = $this->db->rawSelectQuery($q, $params))
        {
            $res = $res[0];
        }

        return $res;
    }

    /**
     * Добавление нового пользователя.
     *
     * @param array $info Данные пользователя.
     * @return int|false ID нового пользователя или false в случае ошибки.
     */
    public function addUser($info)
    {
        if (!$info)
        {
            return false;
        }

        $q = 'INSERT INTO `user` ' . $this->sqlQuerySetUser($info, $values, $valuesBlob);

        if ($ret = $this->db->rawQuery($q, $values, $valuesBlob))
        {
            $ret = $this->db->lastInsertId();
        }

        return $ret;
    }

    /**
     * @param array $info Данные пользователя.
     * @return bool true при успехе или false в случае ошибки
     */
    public function updateUser($info)
    {
        assert($this->id);
        $q = 'UPDATE `user`' . $this->sqlQuerySetUser($info, $values, $valuesBlob) . ' WHERE id = :id LIMIT 1';
        return $this->db->rawQuery($q, $values, $valuesBlob);
    }

    /**
     * Создает SET-параметр для SQL запроса.
     *
     * @param array $info Список полей со значениями.
     * @param array $values Получает значения для запроса к БД.
     * @param array $valuesBlob Получает значения для запроса к БД для BLOB полей.
     * @return string Строка SQL.
     */
    protected function sqlQuerySetUser($info, &$values, &$valuesBlob)
    {
        $values = [];
        $valuesBlob = [];

        $blobFileFld = ['image', 'image_thumb'];
        $moreZeroFld = ['gender', 'country_code', 'birthday'];

        $q = ' SET ';
        foreach ($info as $name => $val)
        {
            if (in_array($name, $moreZeroFld) && $val == -1)
            {
                $q .= " `$name` = NULL, ";
                continue;
            }

            if (in_array($name, $blobFileFld))
            {
                if ($val)
                {
                    //$q .= " `$name` = LOAD_FILE(:$name), ";
                    //$q .= " `$name` = :$name, ";
                    $q .= " `$name` = x'" . bin2hex(file_get_contents($val)) . "', ";
                    //$valuesBlob[":$name"] = $val;
                }
                else
                {
                    $q .= " `$name` = NULL, ";
                    //continue;
                }
                continue;
            }
            elseif ($name == 'password_hash')
            {
                $q .= " `$name` = PASSWORD(:$name), ";
            }
            else
            {
                $q .= " `$name` = :$name, ";
            }

            $values[":$name"] = $val;
        }

        return substr($q, 0, -2) . ' '; // Remove ', '
    }

    /**
     * Список полей, которые не должны содержать начальных и конечных пробельных символов.
     *
     * @return array
     */
    public static function fieldsForTrim()
    {
        return self::$toTrim;
    }

    /**
     * Обрезание строк методом trim(). Обрезаются только строки, заданные в self::$toTrim.
     *
     * @param array $fields Список полей - кандидатов для trim().
     * @return array
     */
    public static function trimFields(&$fields)
    {
        array_walk(
            $fields,
            function (&$val, $key)
            {
                $val = in_array($key, self::$toTrim) ? trim($val) : $val;
            }
        );
    }

    /**
     * Строка для утверждения WHERE SQL запроса что пользователь не удален.
     *
     * @param string $tblAlias Название или псевдоним таблицы, в которой производится проверка условия.
     * @return string Строка SQL.
     */
    protected function sqlWhereNotDeleted($tblAlias = '')
    {
        return ' ' . ($tblAlias ? ($this->db->quoteName($tblAlias) . '.') : '') . '`deleted` = "NO" ';
    }

    /**
     * Строка SQL - проверка, содержит ли поле пустое значение. Подставляется в значения SELECT.
     *
     * @param string $fldName Название поля.
     * @param string $tblAlias Название или псевдоним таблицы в которой проверяется поле.
     * @param string $fldAlias Псевдоним проверяемого поля (если не задан то подставляется название поля).
     * @return string Строка SQL.
     */
    protected function sqlFieldEmptyToken($fldName, $tblAlias = '', $fldAlias = '')
    {
        $tblAlias = $tblAlias ? $this->db->quoteName($tblAlias) . '.' : '';
        $fldAlias = $fldAlias ? $this->db->quoteName($fldAlias) : $this->db->quoteName($fldName);
        $fldName = $this->db->quoteName($fldName);
        return " IF($tblAlias{$fldName} IS NULL OR $tblAlias{$fldName} = '', 'not_exists', 'exists') AS $fldAlias ";
    }

    /**
     * Залогинить пользователя.
     *
     * @param string $login Логин пользователя.
     * @param string $password Пароль.
     * @return bool
     */
    public function logIn($login, $password)
    {
        $success = false;

        $result = $this->db->rawSelectQuery(
            'SELECT `id` FROM `user` WHERE `login` = :login AND `password_hash` = PASSWORD(:password) AND '
            . $this->sqlWhereNotDeleted() . ' LIMIT 1',
            [':login' => $login, ':password' => $password]
        );

        if (count($result) == 1)
        {
            Web::startSession();
            $_SESSION['logged_user']['id'] = $result[0]['id'];
            $success = true;
        }

        return $success;
    }

    /**
     * Разлогирование пользователя.
     */
    public static function logOut()
    {
        Web::startSession();
        unset($_SESSION['logged_user']['id']);
    }

    /**
     * Возвращает ID залогиненого пользователя или false если пользователь не залогинен.
     *
     * @return int|false
     */
    public static function loggedId()
    {
        Web::startSession();
        return empty($_SESSION['logged_user']['id']) ? false : $_SESSION['logged_user']['id'];
    }

    /**
     * Возвращает параметры плейсхолдера несуществующего изображения: альтернативный текст и путь.
     *
     * @return Container
     */
    public static function getNoImageParams()
    {
        $ret = new Container();
        $ret->alt = _('No image');
        $ret->src = '/img/noImage.gif';
        return $ret;
    }
}
