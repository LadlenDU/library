<?php

namespace app\controllers\user\info;

use app\models\forms\UserInfoForm;
use app\models\User;
use app\core\Web;
use app\core\Config;
use app\core\Validator;
use app\core\ContainerHSC;
use app\helpers\Helper;

class Controller extends \app\core\Controller
{
    public function actionIndex()
    {
        $uid = isset($_GET['uid']) ? $_GET['uid'] : false;

        if ($uid)
        {
            $model = new User();
            $values = new ContainerHSC();

            if ($info = $model->getInfo(
                $_GET['uid'],
                [
                    'id',
                    'login',
                    'first_name',
                    'last_name',
                    'email',
                    'phone_mobile',
                    'birthday',
                    'gender',
                    'country_code',
                    'address',
                    'image',
                    'image_thumb'
                ]
            )
            )
            {
                $values->info = $info;
                $values->labels = $model->attributeLabelsColon();

                if ($_GET['uid'] == User::loggedId())
                {
                    Helper::setSelectedMenu($this->view->values, 'info');
                }

                return $this->render('user/info/index', $values);
            }
        }

        //Web::redirect('?action=404');
        return $this->render('404');
    }

    public function actionEdit()
    {
        //$uid = User::loggedId() ?: (empty($_GET['uid']) ? false : $_GET['uid']);
        $uid = User::loggedId();

        if (!$uid)
        {
            return $this->render('access_denied');
        }

        return $this->validateSave($uid);
    }

    public function actionNew()
    {
        if ($uid = User::loggedId())
        {
            Web::redirect('user/info', ['uid' => $uid]);
        }

        return $this->validateSave();
    }

    /**
     * Проверить данные пользователя и сохранить (создать новый аккаунт).
     *
     * @param int|null $uid ID пользователя (если задан).
     * @return string|void Редирект на страницу информации о пользователе в случае успеха
     * или сгенерированный html код если требуется уточнение (произошла ошибка).
     */
    protected function validateSave($uid = null)
    {
        $model = new UserInfoForm($uid);

        if ($model->validate() && ($id = $model->save()))
        {
            Web::redirect('user/info', ['uid' => $id]);
        }

        return $this->render('user/info/modify', $model->getHtmlValues());
    }

    public function actionImage()
    {
        $id = $_GET['uid'];
        $type = empty($_GET['thumb']) ? 'image' : 'image_thumb';

        $image = (new User)->getInfo($id, $type, false);
        if (!empty($image[$type]))
        {
            $finfo = new \finfo(FILEINFO_MIME);
            if ($mime = $finfo->buffer($image[$type]))
            {
                header('Content-Type: ' . $mime);
                return $image[$type];
            }
        }

        header('HTTP/1.0 404 Not Found');
        return '';
    }

    public function actionNotInDbList()
    {
        $validator = new Validator(new UserInfoForm, ['\\app\\core\\Web', 'getGetData']);
        $except = isset(Config::inst()->user['validators'][$_GET['column']]['notInDbList']['except'])
            ? Config::inst()->user['validators'][$_GET['column']]['notInDbList']['except']
            : null;
        $check = $validator->notInDbList($_GET['field'], $_GET['table'], $_GET['column'], $except);
        if ($check)
        {
            Web::sendJsonResponse('success');
        }
        else
        {
            Web::sendJsonResponse('error', $validator->getLastError());
        }
    }

    public function actionEditPassword()
    {
        if (!User::loggedId())
        {
            return $this->render('access_denied');
        }

        return $this->render('user/info/edit_password');
    }

}