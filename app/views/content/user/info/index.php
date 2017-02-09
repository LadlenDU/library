<?php

/* @var $values app\core\ContainerHSC */

use app\helpers\Html;
use app\models\User;
use app\core\Config;
use app\core\HtmlForm;

$this->title = Html::createTitle(_('user info'));
$this->css .= Html::createCssLink('/css/user/user.css');
$this->css .= Html::createCssLink('/css/user/index.css');

define('NOT_DEFINED', _('<-- not defined -->'));

$info = $values->info;
$labels = $values->labels;

$thumbSize = Config::inst()->user['image']['max_thumb_size'];

if ($email = $info->c('email'))
{
    $email = Html::h($email, false);
    $info->email = "<a href='mailto:$email'>$email</a>";
}
else
{
    $info->email = Html::h(NOT_DEFINED, false);
}

if ($birthday = $info->c('birthday'))
{
    list($year, $month, $day) = explode('-', $birthday);
    $time = mktime(0, 0, 0, $month, $day, $year);
    $info->birthday = strftime('%B %e, %Y', $time);
}

if ($gender = $info->c('gender'))
{
    if ($gender == 'MALE')
    {
        $info->gender = _('Male');
    }
    elseif ($gender == 'FEMALE')
    {
        $info->gender = _('Female');
    }
}

foreach ($info as $name => $val)
{
    if (!$val)
    {
        $info[$name] = NOT_DEFINED;
    }
}

?>

<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title"><h4><?php Html::_h('User information:') ?></h4></div>
    </div>

    <div class="panel-body">

        <div class="user_info">

            <div class="row">

                <div class="col-sm-5">

                    <?php echo $this->render(
                        HtmlForm::getUserImageTemplatePath(),
                        $info
                    );
                    ?>

                    <hr class="col-sm-12 visible-xs-block">

                </div>

                <div class="col-sm-7">

                    <div class="row">
                        <div class="col-sm-4 lbl"><?php $labels->login ?></div>
                        <div class="col-sm-8"><?php $info->login ?></div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-4 lbl"><?php $labels->first_name ?></div>
                        <div class="col-sm-8"><?php $info->first_name ?></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 lbl"><?php $labels->last_name ?></div>
                        <div class="col-sm-8"><?php $info->last_name ?></div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-4 lbl"><?php $labels->email ?></div>
                        <div class="col-sm-8"><?php echo $info->c('email') ?></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 lbl"><?php $labels->phone_mobile ?></div>
                        <div class="col-sm-8"><?php $info->phone_mobile ?></div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-4 lbl"><?php $labels->birthday ?></div>
                        <div class="col-sm-8"><?php $info->birthday ?></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 lbl"><?php $labels->gender ?></div>
                        <div class="col-sm-8"><?php $info->gender ?></div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-4 lbl"><?php $labels->country_code ?></div>
                        <div class="col-sm-8"><?php $info->country_name ?></div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 lbl"><?php $labels->address ?></div>
                        <div class="col-sm-8"><?php echo nl2br(Html::h($info->c('address'), false)) ?></div>
                    </div>

                    <hr>

                </div>

            </div>

            <div class="row<?php if ($info->c('id') != User::loggedId())
            {
                echo ' hidden ';
            } ?>">
                <div class="col-sm-12">
                    <a href="/user/info?action=edit" class="btn btn-default"
                       id="btn_edit"><?php Html::_h(
                            'Edit'
                        ) ?></a>
                </div>
            </div>

        </div>

    </div>

</div>