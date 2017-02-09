<?php
/* @var $this app\core\View */

use app\helpers\Html;

$this->title = Html::createTitle(_('сессия вышла'));
?>
<div class="global_message">
    <?php Html::_h(
        'Извините, ваша сессия завершилась, поэтому не удалось выполнить запрос. Это могло произойти если куки были отключены. Пожалуйста, повторите ваш запрос.'
    ) ?><br>
    <a href="<?php Html::mkLnk('/') ?>"><?php Html::_h('Главная страница.') ?></a>
</div>