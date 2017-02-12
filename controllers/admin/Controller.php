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
        Web::redirect('admin', ['action' => 'publishers']);
    }

    public function beforeAction()
    {
        if (!User::loggedId())
        {
            Web::redirect('admin/login');
        }
        parent::beforeAction();
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
}