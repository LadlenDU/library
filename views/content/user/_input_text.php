<?php
/**
 * Поле ввода текста (телефона, email - текстово-подобных полей).
 *
 * @var $values app\core\Container
 */

use app\models\forms\UserInfoForm;
use app\core\ContainerHSC;
use app\core\Config;
//use app\core\HtmlForm;

$vHSC = new ContainerHSC();
$vHSC->name = $values->name;    // Для автопроверки и автовывода.

$vHSC->labelColon = UserInfoForm::attributeLabelsColon()[$values->name];

if (isset(Config::inst()->user['validators'][$values->name]))
{
    $vHSC->validatorParams = $values->htmlForm->validatorParams(
        $values->name,
        Config::inst()->user['validators'][$values->name]
    );
}

?>
<div class="form-group<?php $values->htmlForm->errorClass($values->name) ?>">
    <label for="<?php $vHSC->name ?>"><?php $vHSC->labelColon ?></label>
    <input class="form-control" name="<?php $vHSC->name ?>"
           value="<?php $values->htmlForm->getValues()->values->{$values->name} ?>"
        <?php
        echo $values->params . ' ';
        $values->htmlForm->maxlengthParam($values->name);
        echo $vHSC->c('validatorParams');
        ?>>

    <p class="help-block help-block-error"><?php $values->htmlForm->errorMsg($values->name) ?></p>
</div>