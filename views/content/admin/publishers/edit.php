<?php

/* @var $this app\core\View */
/* @var $values app\core\Container */

use app\widgets\Form;
use app\helpers\Html;

$this->title = Html::createTitle('редактировать издательство');

?>
<h2>Редактировать название издательства # <?php Html::h($values->id) ?></h2>
<?php echo Form::startForm(['action' => '/admin/publisher?action=modify']) ?>
<input type="hidden" name="id" value="<?php Html::h($values->id) ?>">
<input type="text" name="name" value="<?php Html::h($values->name) ?>">
<input type="submit" class="btn btn-default btn-sm" value="Редактировать">
<?php echo Form::endForm() ?>
