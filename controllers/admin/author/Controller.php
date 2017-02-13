<?php

namespace app\controllers\admin\author;

use app\core\Web;
use app\core\Container;
use app\models\Author;


class Controller extends \app\controllers\admin\Controller
{
    public function actionModify()
    {
        $publisher = new Author;

        if (!empty($_GET['id']))
        {
            if ($item = $publisher->getAuthor($_GET['id']))
            {
                $values = new Container();
                $values->id = $_GET['id'];
                $values->name = $item['name'];
                return $this->render('admin/authors/edit', $values);
            }
            //TODO: рендер страницы ошибки
        }

        if (!empty($_POST['id']))
        {
            $publisher->updateAuthor($_POST['id'], $_POST['name']);
            Web::redirect('admin', ['action' => 'authors']);
        }

        return $this->render('404');
    }

    public function actionCreate()
    {
        $publisher = new Author;
        $publisher->addAuthor(
            [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'birthday' => strtotime($_POST['birthday'])
            ]
        );
        Web::redirect('admin', ['action' => 'authors']);
    }

    public function actionRemove()
    {
        $publisher = new Author;
        $publisher->removeAuthor($_POST['id']);
        Web::redirect('admin', ['action' => 'authors']);
    }

    public function actionRestore()
    {
        $publisher = new Author;
        $publisher->restoreAuthor($_POST['id']);
        Web::redirect('admin', ['action' => 'authors']);
    }
}
