<?php

namespace app\widgets;

class Navbar
{
    public static function headerPanel()
    {
        $s =
            '<nav class="navbar navbar-inverse navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header">';

        if (UserComponent::getInstance()->getUserId())
        {
            $s .=
                '<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse">
                    <span class="sr-only">Переключить навигацию</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>';
        }

        $s .= '<a class="navbar-brand" href="/">Список сообщений</a>
                    </div>';
        if (UserComponent::getInstance()->getUserId())
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

        if (UserComponent::getInstance()->getUserId())
        {
            $params['form'] = isset($params['form']) ? $params['form'] : [];
            $params['button'] = isset($params['button']) ? $params['button'] : [];

            $params['form']['action'] = '/user/logout';
            $params['form']['method'] = 'POST';

            $s .= FormWidget::startForm($params['form'])
                . '<input type="hidden" name="logout" value="1">'
                . '<p class="navbar-text">'
                . CommonHelper::_h('Ваш логин:') . ' ' . UserComponent::getInstance()->getUserInfo()->login
                . '</p><button type="submit" '
                . CommonHelper::getHtmlTagParams($params['button'])
                . '>' . CommonHelper::_h('Выйти') . '</button>'
                . FormWidget::endForm();
        }

        return $s;
    }
}