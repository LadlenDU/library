<?php

namespace app\controllers\user;

use app\core\HtmlForm;
use app\core\Web;
use app\core\ContainerHSC;
use app\models\User;
use app\helpers\Helper;

class Controller extends \app\base\Controller
{
    public function actionIndex()
    {
        $model = new User;

        $values = new ContainerHSC();
        $values->head = $model->attributeLabels();
        $values->info = $model->getUsers();

        Helper::setSelectedMenu($this->view->values, 'users');

        return $this->render('user/index', $values);
    }

    public function actionLogin()
    {
        $model = new User;
        if (isset($_POST['login']) && isset($_POST['password']))
        {
            if ($model->logIn($_POST['login'], $_POST['password']))
            {
                //Web::redirectByParam();
                Web::redirect('user/info', ['uid' => $model::loggedId()]);
            }

            $this->view->values->credentials = ['login' => $_POST['login']];
            $this->view->values->errors = ['wrong_credentials' => true];
            $this->view->values->redirectUrl = $_POST[HtmlForm::REDIRECT_URL_NAME];

            return $this->render('user/wrong_credentials');
        }
        else
        {
            // Похоже это не корректное действие - уходим.
            Web::redirect();
        }
    }

    public function actionLogout()
    {
        User::logOut();
        Web::redirectByParam();
    }
}
