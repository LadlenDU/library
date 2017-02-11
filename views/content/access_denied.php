<?php
/* @var $this app\core\View */

use app\helpers\Html;

$this->title = Html::createTitle(_('доступ запрещен'));
?>
<div class="global_message"><?php Html::_h('Доступ запрещен.') ?>
    <br>
    <a href="<?php Html::mkLnk('/') ?>"><?php Html::_h('Домашняя страница.') ?></a>
</div>