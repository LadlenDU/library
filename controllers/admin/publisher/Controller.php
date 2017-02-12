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
        $tt = 100;
    }

    public function actionCreate()
    {
        $publisher = new Publisher;
        $publisher->addPublisher($_POST['name']);
        Web::redirect('admin', ['action' => 'publishers']);
    }
}
