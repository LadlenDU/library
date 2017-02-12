<?php

namespace app\controllers\admin;

use app\core\Container;
use app\models\User;
use app\core\Web;

class Controller extends \app\core\Controller
{
    protected $layout = 'admin.php';

    public function actionIndex()
    {
        Web::redirect('admin', ['action' => 'authors']);
    }

    public function beforeAction()
    {
        if (!User::loggedId())
        {
            Web::redirect('admin', ['action' => 'loginpage']);
        }
        parent::beforeAction();
    }

    public function actionLoginPage()
    {
        if (User::loggedId())
        {
            Web::redirect('admin', ['action' => 'publishers']);
        }
        return $this->render('admin/login');
    }

    public function actionAuthors()
    {
        return $this->render('admin/authors');
    }

    public function actionBooks()
    {
        return $this->render('admin/books');
    }

    public function actionPublishers()
    {
        return $this->render('admin/publishers');
    }

    public function actionLogin()
    {
        if (isset($_POST['login']))
        {
            $user = new User;
            if ($user->logIn($_POST['login'], $_POST['password']))
            {
                Web::redirect('admin');
            }
            else
            {
                $params = new Container;
                $params->wrong_login = true;
                return $this->render('admin/login', $params);
            }
        }

        return '';
    }

    public function actionLogout()
    {
        $user = new User;
        $user->logOut();

        //TODO: возвращаться на страницу с которой разлогинились ??? (на данный момент не актуально)
        Web::redirect('admin', ['action' => 'publishers']);
    }
}