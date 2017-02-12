<?php

namespace app\controllers\admin;

use app\models\User;
use app\core\Web;

class Controller extends \app\core\Controller
{
    protected $layout = 'admin.php';

    public function actionIndex()
    {
        $ret = User::loggedId() ? $this->render('admin/index') : $this->render('admin/login');
        return $ret;
    }

    public function actionLogin()
    {
        if (isset($_POST['login']))
        {
            $user = new User;
            if ($user->logIn($_POST['login'], $_POST['password']))
            {
                Web::redirect('admin/index');
            }
            else
            {
                return $this->render('admin/login', ['wrong_login' => true]);
            }
        }
    }
}