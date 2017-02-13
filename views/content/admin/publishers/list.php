<?php

/* @var $this app\core\View */
/* @var $values app\core\Container */

use app\widgets\Form;
use app\helpers\Html;

$this->title = Html::createTitle('список издательств');

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

        /*$("#form_publisher_list").submit(function () {
        <?php  ?>
         });*/
    });
    // ]]>
</script>
<h2>Издательства</h2>
<?php echo Form::startForm(['action' => '/admin/publisher?action=create']) ?>
<input type="text" name="name">
<input type="submit" class="btn btn-default btn-sm" value="Создать новое издательство">
<?php echo Form::endForm() ?>
<br><br>
<table id="admin_items_list" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Название</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php
        foreach ($values->items as $item): ?>
        <tr class="<?php echo $item->getDeleted() ? 'dimmed' : '' ?>">
            <td><?php Html::h($item->getName()) ?></td>
            <td>
                <?php if ($item->getDeleted()): ?>
                    <?php echo Form::startForm(['action' => '/admin/publisher?action=restore']) ?>
                    <input type="hidden" name="id" value="<?php Html::h($item->getId()) ?>">
                    <button type="submit" class="btn btn-default btn-sm">
                        <span class="glyphicon glyphicon-remove"></span>&nbsp;Удалено - восстановить
                    </button>
                    <?php echo Form::endForm() ?>
                <?php else: ?>
                    <a href="/admin/publisher?action=modify&id=<?php echo urlencode($item->getId()) ?>"
                       class="btn btn-default btn-sm" style="float:left;margin-right:10px">
                        <span class="glyphicon glyphicon-edit"></span>&nbsp;Редактировать
                    </a>
                    <?php echo Form::startForm(['action' => '/admin/publisher?action=remove']) ?>
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
        <th>Название</th>
        <th>&nbsp;</th>
    </tr>
    </tfoot>
</table>
