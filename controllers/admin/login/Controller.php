<?php

namespace app\controllers\admin\login;

use app\core\Container;
use app\models\User;
use app\core\Web;

class Controller extends \app\core\Controller
{
    protected $layout = 'admin.php';

    public function actionIndex()
    {
        return $this->render('admin/login');
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