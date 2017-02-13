<?php

/* @var $this app\core\View */
/* @var $values app\core\Container */

use app\widgets\Form;
use app\helpers\Html;

$this->title = Html::createTitle('список авторов');

?>
<script type="text/javascript">
    // <![CDATA[
    $(function () {
        var dtTblInfo = jQuery.extend(true, {}, app.dataTableInfo);
        dtTblInfo.columnDefs = [
            {orderable: false, targets: -1}
        ];
        dtTblInfo.bFilter = false;
        $('#admin_items_list').DataTable(dtTblInfo);
    });
    // ]]>
</script>
<h2>Авторы</h2>
<?php echo Form::startForm(['action' => '/admin/author?action=create']) ?>
<?php echo $this->render(__DIR__ . '/_info.php'); ?>
<input type="submit" class="btn btn-default btn-sm" value="Создать нового автора">
<?php echo Form::endForm() ?>
<br><br>
<table id="admin_items_list" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Родился</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($values->items as $item): ?>
        <tr class="<?php echo $item->getDeleted() ? 'dimmed' : '' ?>">
            <td><?php Html::h($item->getFirstName()) ?></td>
            <td><?php Html::h($item->getLastName()) ?></td>
            <td><?php Html::h($item->getBirthday()->format('F j, Y')) ?></td>
            <td>
                <?php if ($item->getDeleted()): ?>
                    <?php echo Form::startForm(['action' => '/admin/author?action=restore']) ?>
                    <input type="hidden" name="id" value="<?php Html::h($item->getId()) ?>">
                    <button type="submit" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-remove"></span>&nbsp;Удален - восстановить
                    </button>
                    <?php echo Form::endForm() ?>
                <?php else: ?>
                    <a href="/admin/author?action=modify&id=<?php echo urlencode($item->getId()) ?>"
                       class="btn btn-default btn-sm" style="float:left;margin-right:10px">
                        <span class="glyphicon glyphicon-edit"></span>&nbsp;Редактировать
                    </a>
                    <?php echo Form::startForm(['action' => '/admin/author?action=remove']) ?>
                    <input type="hidden" name="id" value="<?php Html::h($item->getId()) ?>">
                    <button type="submit" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-remove"></span>&nbsp;Удалить
                    </button>
                    <?php echo Form::endForm() ?>
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
    <tfoot>
    <tr>
        <th>Имя</th>
        <th>Фамилия</th>
        <th>Родился</th>
        <th>&nbsp;</th>
    </tr>
    </tfoot>
</table>
