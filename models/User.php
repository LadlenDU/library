<?php

namespace app\models;

#use app\core\Model;
use app\core\Web;
use app\helpers\Db;
#use Entities;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Mapping\ClassMetadata;

/**
 * User модель пользователя.
 *
 * @package app\models
 */
class User extends EntityRepository//extends Model
{
    /** @var int Идентификатор пользователя. */
    protected $id;

    public function __construct($id = null)
    {
        //$yy = new \Entities\User;
        $this->id = $id;
        $metadata = new ClassMetadata('\\Entities\\User');
        parent::__construct(Db::em(), $metadata);
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

        $rt = $this->createQueryBuilder('u')
            ->where('u.login = :login')
            ->setParameter('login', $login)
            ->getQuery()
            ->getOneOrNullResult();

        return $rt;

        #Db::em()->persist($user);
        #Db::em()->flush();

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
