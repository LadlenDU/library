<?php

namespace app\widgets;

use app\helpers\Html;
use app\core\Csrf;

class Form
{
    public static function startForm($params)
    {
        $params['method'] = isset($params['method']) ? $params['method'] : 'POST';

        $s = '<form ' . Html::mkHtmlTagParams($params) . ">\n"
            . '<input type="hidden" name="' . Csrf::inst()->getCsrfTokenName() . '" '
            . 'value="' . Csrf::inst()->getCsrfToken() . '">' . "\n";

        return $s;
    }

    public static function endForm()
    {
        return "</form>\n";
    }
}
