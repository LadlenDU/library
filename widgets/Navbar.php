<?php

namespace app\widgets;

use app\models\User;
use app\helpers\Html;

class Navbar
{
    public static function headerPanel()
    {
        $s =
            '<nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">';

        if (User::loggedId())
        {
            $s .=
                '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                    <span class="sr-only">Переключить навигацию</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>';
        }

        $s .= '<a class="navbar-brand" href="/">Библиотека</a>
            <ul class="nav navbar-nav">
            <li class="active"><a href="' . Html::mkLnk('/admin?action=publishers', false). '">Издательства</a></li>
            <li><a href="' . Html::mkLnk('/admin?action=authors', false). '">Авторы</a></li>
            <li><a href="' . Html::mkLnk('/admin?action=books', false). '">Книги</a></li>
          </ul>
                    </div>';

        if (User::loggedId())
        {
            $s .= '<div class="navbar-collapse collapse" id="w0-collapse">'
                . self::htmlLogoutItem(
                    [
                        'form' => ['class' => 'navbar-right nav', 'role' => 'form'],
                        'button' => ['class' => 'btn navbar-btn']
                    ]
                )
                . '      </div>';
        }

        $s .= '</div>
            </nav>';

        return $s;
    }

    /**
     * Возвращает строку для разлогинивания пользователя (также краткую информацию о пользователе).
     *
     * @param array $params массив параметров
     * @return string html строка для разлогинивания
     */
    public static function htmlLogoutItem($params = [])
    {
        $s = '';

        if (User::loggedId())
        {
            $user = new User;

            $params['form'] = isset($params['form']) ? $params['form'] : [];
            $params['button'] = isset($params['button']) ? $params['button'] : [];

            $params['form']['action'] = '/admin?action=logout';
            $params['form']['method'] = 'POST';

            $s .= Form::startForm($params['form'])
                . '<input type="hidden" name="logout" value="1">'
                . '<p class="navbar-text">'
                . Html::_h('Ваш логин:', false) . ' ' . $user->getLoggedUserInfo()->getLogin()
                . '</p><button type="submit" '
                . Html::mkHtmlTagParams($params['button'])
                . '>' . Html::_h('Выйти', false) . '</button>'
                . Form::endForm();
        }

        return $s;
    }
}