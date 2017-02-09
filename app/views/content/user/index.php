<?php

/* @var $values app\core\ContainerHSC */

use app\helpers\Html;

$this->title = Html::createTitle(_('list of users'));
$this->css .= Html::createCssLink('/css/user/user.css');

?>

<table class="table table-hover" id="user_table">
    <thead>
    <tr>
        <th><?php $values->head->id ?></th>
        <th><?php $values->head->login ?></th>
        <th><?php $values->head->first_name ?></th>
        <th><?php $values->head->last_name ?></th>
        <th><?php $values->head->email ?></th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($values->info as $val)
    {
        $aTag = '<a href="/user/info?uid=' . $val->c('id') . '" target="_blank">';
        ?>
        <tr>
            <td><?php echo $aTag ?><?php $val->id ?></a></td>
            <td><?php echo $aTag ?><?php $val->login ?></a></td>
            <td><?php echo $aTag ?><?php $val->first_name ?></a></td>
            <td><?php echo $aTag ?><?php $val->last_name ?></a></td>
            <td><?php echo $aTag ?><?php $val->email ?></a></td>
        </tr>
    <?php } ?>
    </tbody>
</table>
