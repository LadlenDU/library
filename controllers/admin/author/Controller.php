<?php

namespace app\controllers\admin\author;

use app\core\Container;
use app\models\Publisher;
use app\core\Web;

class Controller extends \app\controllers\admin\Controller
{
    public function actionModify()
    {
        $publisher = new Publisher;

        if (!empty($_GET['id']))
        {
            if ($item = $publisher->getPublisher($_GET['id']))
            {
                $values = new Container();
                $values->id = $_GET['id'];
                $values->name = $item['name'];
                return $this->render('admin/publishers/edit', $values);
            }
            //TODO: рендер страницы ошибки
        }

        if (!empty($_POST['id']))
        {
            $publisher->updatePublisher($_POST['id'], $_POST['name']);
            Web::redirect('admin', ['action' => 'publishers']);
        }

        return $this->render('404');
    }

    public function actionCreate()
    {
        $publisher = new Publisher;
        $publisher->addPublisher($_POST['name']);
        Web::redirect('admin', ['action' => 'publishers']);
    }

    public function actionRemove()
    {
        $publisher = new Publisher;
        $publisher->removePublisher($_POST['id']);
        Web::redirect('admin', ['action' => 'publishers']);
    }

    public function actionRestore()
    {
        $publisher = new Publisher;
        $publisher->restorePublisher($_POST['id']);
        Web::redirect('admin', ['action' => 'publishers']);
    }
}
