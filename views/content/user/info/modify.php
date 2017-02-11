<?php

/* @var $values app\core\Container */

use app\helpers\Html;
use app\core\Config;
use app\core\Container;
use app\core\HtmlForm;
use app\models\User;
use app\models\forms\UserInfoForm;

$this->title = Html::createTitle(_('modify user info'));
$this->css .= Html::createCssLink('/css/user/index.css');
$this->css .= Html::createCssLink('/css/user/info/modify.css');
$this->js .= Html::createJsLink('/js/user/EditForm.js');

$NOTHING_SELECTED = '  ---  ';  // Текст не выбранного значения для элемента <selected>
$INPUT_TP = HtmlForm::getInputTemplatePath();    // Путь к файлу шаблона <input>

$htmlForm = new HtmlForm($values);

if (!$values->values->c('birth') && $birthday = $values->values->c('birthday'))
{
    $values->values->birth = new Container;
    list($values->values->birth->year, $values->values->birth->month, $values->values->birth->day)
        = explode('-', $birthday);
}

if ($values->values->c('id'))
{
    $action = 'edit';
}
else
{
    $action = 'new';
}

?>

<script type="text/javascript">
    // <![CDATA[

    $(function () {
        // Если JS включен, то включим элементы предварительного просмотра изображения.
        $("#image_input-group-btn").addClass("input-group-btn");
        $("#image_btn_btn-primary").addClass("btn btn-primary");
        $("#image_browse").css("display", "inline");
        $("#image_name").css("display", "block");
        $("#image_name ~ label").css("display", "table-cell");

        var fileHtml = $('<textarea/>').html($('#image_noscript').html()).val();    // Извращение из-за особенности Chrome.
        var file = $(fileHtml);
        file.css("display", "none");
        $("#image_noscript").after(file);

        app.helper.extend(app.user.EditForm, app.Form);
        var editForm = new app.user.EditForm($(".user_info_form"));

        <?php /** @type {namespace} - Список валидаторов - см. файл конфигурации. */ ?>
        editForm.validators = <?php Html::j(Config::inst()->user['validators']) ?>;

        <?php /** @type {namespace} - Данные пустого изображения. */ ?>
        editForm.noImage = {};
        editForm.noImage.original = <?php Html::j(User::getNoImageParams()->ga()) ?>;
        editForm.noImage.thumbnail = <?php Html::j(User::getNoImageParams()->ga()) ?>;
    });

    // ]]>
</script>

<div class="panel panel-default">

    <div class="panel-heading">
        <div class="panel-title"><h4><?php
                if ($values->values->c('id'))
                {
                    Html::_h('Please modify your information');
                }
                else
                {
                    Html::_h('Please enter your information');
                }
                ?></h4></div>
    </div>

    <div class="panel-body">
        <form class="form-vertical user_info_form" enctype="multipart/form-data"
              action="/user/info/?action=<?php Html::h($action) ?>"
              method="POST">
            <?php HtmlForm::inputCSRF() ?>

            <input type="hidden" class="dyn_data didntPassValidation"
                   value="<?php Html::_h("Some fields aren't correct! Please check the form.") ?>">

            <fieldset>

                <div class="row">

                    <div class="col-sm-5 col-sm-push-7">

                        <div class="form-group<?php $htmlForm->errorClass('image') ?>">
                            <div class="image_input_container">

                                <?php // Данные по размещению временно загруженного изображения. ?>
                                <input type="hidden" name="stored_image[original]"
                                       value="<?php $values->storedImage->original ?>">
                                <input type="hidden" name="stored_image[thumbnail]"
                                       value="<?php $values->storedImage->thumbnail ?>">

                                <label class="col-sm-12"
                                       for="image"><?php $values->formLabelsColon->image ?></label>

                                <?php echo $this->render(
                                    HtmlForm::getUserImageTemplatePath(),
                                    $values->c('values')
                                );
                                ?>

                                <div class="col-sm-12">
                                    <div class="input-group">
                                        <label id="image_input-group-btn">
                                    <span id="image_btn_btn-primary">
                                        <input type="hidden" name="MAX_FILE_SIZE"
                                               value="<?php $values->maxFileSize ?>"/>

                                        <span id="image_browse"><?php Html::_h('Browse') ?>&hellip;</span>

                                        <noscript id="image_noscript">
                                            <input type="file" id="image"
                                                   name="image"
                                                   accept="<?php echo '.' . implode(
                                                           ', .',
                                                           Config::inst()->user['image']['types_allowed_extension']
                                                       ) ?>"
                                                   data-noSupportFileUpload-text="<?php Html::_h(
                                                       'File upload not supported by your browser.'
                                                   ) ?>"
                                                   data-v-unknownImageMime-text="<?php Html::_h(
                                                       Config::inst()->validator_messages['imageMIME']['err_MIME']
                                                   ) ?>"
                                                   data-v-unsupportedImageExtension-text="<?php Html::_h(
                                                       Config::inst()->validator_messages['imageMIME']['err_ext']
                                                   ) ?>"
                                                   data-v-imageSizeIs-text="<?php Html::_h(
                                                       Config::inst(
                                                       )->validator_messages['imageMaxSize']['your_image_size']
                                                   ) ?>"
                                                   data-v-imageSizeNotLessThan-text="<?php Html::_nhs(
                                                       Config::inst()->validator_messages['imageMaxSize']['err_n']['s'],
                                                       Config::inst()->validator_messages['imageMaxSize']['err_n']['p'],
                                                       $values->c('maxFileSize') + 1,
                                                       $values->c('maxFileSize') + 1
                                                   )
                                                   ?>">
                                        </noscript>
                                    </span>
                                        </label>
                                        <input id="image_name" type="text" class="form-control" readonly>
                                        <label class="input-group-btn"
                                               title="<?php Html::_h('Remove (or restore saved) image') ?>">
                                            <span
                                                class="btn btn-primary glyphicon glyphicon-trash remove_uploaded_image"></span>
                                        </label>
                                    </div>
                                    <p class="help-block"><?php echo Html::_h(
                                                'Allowed formats: ',
                                                false
                                            ) . 'JPEG, GIF, PNG' ?></p>

                                </div>

                            </div>

                            <p class="col-sm-12 help-block-error"><?php $htmlForm->errorMsg('image') ?></p>
                            <hr class="col-sm-12 visible-xs-block">

                        </div>

                    </div>

                    <div class="col-sm-7 col-sm-pull-5">
                        <?php
                        echo $this->render(
                            $INPUT_TP,
                            new Container(
                                [
                                    'name' => 'login',
                                    'params' => 'autofocus="autofocus" id="login" type="text" placeholder="' . Html::_h(
                                            'Enter login',
                                            false
                                        ) . '"',
                                    'htmlForm' => $htmlForm,
                                ]
                            )
                        );
                        if ($values->values->c('id'))
                        {
                            ?>
                            <div class="form-group">
                                <label><?php Html::h(
                                        UserInfoForm::attributeLabelsColon()['password']
                                    ) ?></label>
                                <a target="_blank" href="/user/info?action=editPassword"
                                   title="<?php Html::_h('Click to edit password') ?>"
                                   class="btn btn-default form-control" id="password">
                                    <?php Html::_h('Edit password') ?>
                                </a>
                            </div>
                            <?php
                        }
                        else
                        {
                            echo $this->render(
                                $INPUT_TP,
                                new Container(
                                    [   //TODO: скорее всего надо при отправке назад формы не вписывать пароль
                                        'name' => 'password',
                                        'params' => 'type="password" id="password" placeholder="' . Html::_h(
                                                'Enter password',
                                                false
                                            ) . '"',
                                        'htmlForm' => $htmlForm,
                                    ]
                                )
                            );
                            echo $this->render(
                                $INPUT_TP,
                                new Container(
                                    [
                                        'name' => 'password_confirm',
                                        'params' => 'type="password" id="password_confirm" placeholder="' . Html::_h(
                                                'Confirm password',
                                                false
                                            ) . '"',
                                        'htmlForm' => $htmlForm,
                                    ]
                                )
                            );
                        }
                        ?>

                        <hr>

                        <?php
                        echo $this->render(
                            $INPUT_TP,
                            new Container(
                                [
                                    'name' => 'first_name',
                                    'params' => 'type="text" id="first_name" placeholder="' . Html::_h(
                                            'Enter first name',
                                            false
                                        ) . '"',
                                    'htmlForm' => $htmlForm,
                                ]
                            )
                        );
                        echo $this->render(
                            $INPUT_TP,
                            new Container(
                                [
                                    'name' => 'last_name',
                                    'params' => 'type="text" id="last_name" placeholder="' . Html::_h(
                                            'Enter last name',
                                            false
                                        ) . '"',
                                    'htmlForm' => $htmlForm,
                                ]
                            )
                        );
                        ?>

                        <hr>

                        <?php
                        echo $this->render(
                            $INPUT_TP,
                            new Container(
                                [
                                    'name' => 'email',
                                    'params' => 'type="email" id="email" placeholder="' . Html::_h(
                                            'Enter email',
                                            false
                                        ) . '"',
                                    'htmlForm' => $htmlForm,
                                ]
                            )
                        );
                        echo $this->render(
                            $INPUT_TP,
                            new Container(
                                [
                                    'name' => 'phone_mobile',
                                    'params' => 'type="tel" id="phone_mobile" placeholder="' . Html::_h(
                                            'Enter mobile phone',
                                            false
                                        ) . '"',
                                    'htmlForm' => $htmlForm,
                                ]
                            )
                        );
                        ?>

                        <hr>

                        <div class="form-group<?php $htmlForm->errorClass('birthday') ?>">
                            <label for="birthday"><?php $values->formLabelsColon->birth_date ?></label>
                            <input type="hidden" data-name="birthday"
                                   data-v-date-text="<?php Html::_h(
                                       Config::inst()->validator_messages['date']['err']
                                   ) ?>">

                            <div class="row">
                                <div class="col-sm-3">
                                    <select id="birthday" name="birth[day]" class="form-control">
                                        <option value="-1"><?php Html::_h('Day') ?></option>
                                        <option value="-1"><?php echo $NOTHING_SELECTED ?></option>
                                        <?php for ($i = 1; $i <= 31; ++$i): ?>
                                            <option value="<?php echo $i ?>"<?php
                                            if ("$i" == $values->values->birth->c('day'))
                                            {
                                                echo ' selected="selected"';
                                            }
                                            ?>><?php echo $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <select name="birth[month]" class="form-control">
                                        <option value="-1"><?php Html::_h('Month') ?></option>
                                        <option value="-1"><?php echo $NOTHING_SELECTED ?></option>
                                        <?php foreach ($values->monthsList as $key => $month): ?>
                                            <option value="<?php Html::h($key) ?>"<?php
                                            $selMonth = (string)$values->values->birth->c('month');
                                            if ("$key" == $selMonth - 1)
                                            {
                                                echo ' selected="selected"';
                                            }
                                            ?>><?php Html::h($month) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-sm-3">
                                    <select name="birth[year]" class="form-control">
                                        <option value="-1"><?php Html::_h('Year') ?></option>
                                        <option value="-1"><?php echo $NOTHING_SELECTED ?></option>
                                        <?php for ($i = $values->year->c('first');
                                                   $i >= $values->year->c('last');
                                                   --$i): ?>
                                            <option value="<?php echo $i ?>"<?php
                                            if ("$i" == $values->values->birth->c('year'))
                                            {
                                                echo ' selected="selected"';
                                            }
                                            ?>><?php echo $i ?></option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                            </div>

                            <p class="help-block help-block-error"><?php $htmlForm->errorMsg('birthday') ?></p>
                        </div>

                        <div class="form-group">
                            <label for="gender"><?php $values->formLabelsColon->gender ?></label>

                            <select class="form-control" id="gender" name="gender">
                                <option value="-1"><?php echo $NOTHING_SELECTED ?></option>
                                <option value="MALE"<?php
                                if ('MALE' == $values->values->c('gender'))
                                {
                                    echo ' selected="selected"';
                                }
                                ?>><?php Html::_h('Male') ?></option>
                                <option value="FEMALE"<?php
                                if ('FEMALE' == $values->values->c('gender'))
                                {
                                    echo ' selected="selected"';
                                }
                                ?>><?php Html::_h('Female') ?></option>
                            </select>
                        </div>

                        <hr>

                        <div class="form-group">
                            <label for="country"><?php $values->formLabelsColon->country ?></label>
                            <select class="form-control" id="country" name="country">
                                <option value="-1"><?php echo $NOTHING_SELECTED ?></option>
                                <?php foreach ($values->countries as $country): ?>
                                    <option value="<?php $country->code ?>"<?php
                                    if ($country->c('code') == $values->values->c('country_code'))
                                    {
                                        echo ' selected="selected"';
                                    }
                                    ?>><?php $country->name ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="address"><?php $values->formLabelsColon->address ?></label>
                        <textarea class="form-control" id="address" name="address" rows="4"
                                  maxlength="<?php $values->fieldMaxSizes->address ?>"><?php $values->values->address ?></textarea>
                        </div>

                    </div>

                </div>
                <div class="row">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="btn_submit" value="submit" class="btn btn-default"><?php
                            if ($values->values->c('id'))
                            {
                                Html::_h('Edit');
                            }
                            else
                            {
                                Html::_h('Submit');
                            } ?></button>
                    </div>
                </div>

            </fieldset>

        </form>
    </div>

</div>