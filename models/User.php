<?php

namespace app\models;

use app\core\Model;
use app\core\Web;
use app\helpers\Db;
use Entities;


/**
 * User модель пользователя.
 *
 * @package app\models
 */
class User extends Model
{
    /** @var int Идентификатор пользователя. */
    protected $id;

    public function __construct($id = null)
    {
        $this->id = $id;
        parent::__construct();
    }

    public function attributeLabels() {}

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

        $user = new User;

        Db::em()->persist($user);
        Db::em()->flush();

        /*$result = $this->db->rawSelectQuery(
            'SELECT `id` FROM `user` WHERE `login` = :login AND `password_hash` = PASSWORD(:password) AND '
            . $this->sqlWhereNotDeleted() . ' LIMIT 1',
            [':login' => $login, ':password' => $password]
        );

        if (count($result) == 1)
        {
            Web::startSession();
            $_SESSION['logged_user']['id'] = $result[0]['id'];
            $success = true;
        }*/

        Setup::createConfiguration($isDevMode);

        EntityManager::create($connectionParams, $config);

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

}
