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
        $('#publisher_list').DataTable(dtTblInfo);
    });
    // ]]>
</script>
<h2>Издательства</h2>
<?php Form::startForm(['action' => '/admin/']) ?>
<table id="publisher_list" class="table table-striped table-bordered">
    <thead>
    <tr>
        <th>Название</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($values->items as $item): ?>
    <tr>
        <td><?php Html::h($item->name) ?></td>
        <td>
            <button type="submit" class="btn btn-default btn-sm" data-id="<?php $item->id ?>" data-action="edit">
                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;Редактировать
            </button>
            <button type="submit" class="btn btn-default btn-sm" data-id="<?php $item->id ?>" data-action="remove">
                <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;Удалить
            </button>
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
<?php Form::endForm() ?>