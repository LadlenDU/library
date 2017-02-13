<?php

namespace app\controllers\admin;

use app\core\Container;
use app\models\User;
use app\models\Publisher;
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
        return $this->render('admin/authors/list');
    }

    public function actionBooks()
    {
        return $this->render('admin/books/list');
    }

    public function actionPublishers()
    {
        $publisher = new Publisher;
        $values = new Container();
        $values->items = $publisher->getPublishers();
        return $this->render('admin/publishers/list', $values);
    }

    public function actionModify()
    {
        $tt = 100;
    }

    public function actionCreate()
    {
        $publisher = new Publisher;
        $publisher->addPublisher($_POST['name']);
        Web::redirect('admin', ['action' => 'publishers']);
    }
}