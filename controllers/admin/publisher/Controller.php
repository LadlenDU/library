<?php

namespace app\controllers\admin\publisher;

use app\core\Container;
use app\models\User;
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
                return $this->render('admin/publishers/edit', ['id' => $_GET['id'], 'name' => $item->getName()]);
            }
            else
            {
                return $this->render('404');
            }
        }
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
}
