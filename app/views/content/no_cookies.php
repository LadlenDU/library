<?php
/* @var $this app\core\View */

use app\helpers\Html;

$this->title = Html::createTitle('куки не включены');
?>
<div class="global_message"><?php Html::_h(
        'Куки в вашем браузере отключены. Пожалуйста, включите их.'
    ) ?>
    <br>
    <a href="<?php Html::h(
        'https://www.google.ru/search?q=browser+turn+on+cookies&ie=utf-8&oe=utf-8&client=firefox-b&gfe_rd=cr&ei=aWh3WNOuMoqO6ASk_bHQCg'
    ) ?>" target="_blank"><?php Html::_h('Нажмите здесь чтобы узнать как включить куки.') ?></a>
</div>