<?php
/* @var $this app\core\View */

use app\helpers\Html;

$this->title = Html::createTitle(_('неправильный логин или пароль'));
?>
<div class="global_message"><?php Html::_h('Неправильный логин или пароль. Попробуйте ещё раз.') ?>
    <br>
    <a href="//<?php Html::h($this->values->redirectUrl) ?>"><?php Html::_h('< Назад') ?></a>
</div>
