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

        /*$("#form_publisher_list").submit(function () {
        <?php  ?>
         });*/
    });
    // ]]>
</script>
<h2>Издательства</h2>
<?php echo Form::startForm(['action' => '/admin?action=create&type=publisher']) ?>
    <input type="text" name="name">
    <input type="submit" class="btn btn-default btn-sm" value="Создать новое издательство">
<?php echo Form::endForm() ?>
<br><br>
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
            <td><?php Html::h($item->getName()) ?></td>
            <td>
                <a href="/admin?action=modify&id=<?php urlencode($item->getId()) ?>">
                    <input type="button" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;Редактировать
                    </input>
                </a>
                <!--<button type="submit" class="btn btn-default btn-sm" name="remove" value="remove">
                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>&nbsp;Удалить
                </button>-->
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
