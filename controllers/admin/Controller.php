<?php

namespace app\controllers\admin;

class Controller extends \app\core\Controller
{
    protected $layout = 'admin.php';

    public function actionIndex()
    {
        return $this->render('user/index', $values);
    }
}