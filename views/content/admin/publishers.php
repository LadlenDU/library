<?php

/* @var $this app\core\View */
/* @var $values app\core\Container */

#use app\widgets\Form;
use app\helpers\Html;

$this->title = Html::createTitle('список издательств');

?>
<script type="text/javascript">
    // <![CDATA[
    $(document).ready(function () {
        var dtTblInfo = app.dataTableInfo;
        dtTblInfo.columnDefs = [
            {orderable: false, targets: -1}
        ];
        $('#publisher_list').DataTable(dtTblInfo);
    });
    // ]]>
</script>
<h2>Издательства</h2>
<table id="publisher_list" class="table table-striped table-bordered" width="100%" cellspacing="0">
    <thead>
    <tr>
        <th>Название</th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tfoot>
    <tr>
        <th>Название</th>
        <th>&nbsp;</th>
    </tr>
    </tfoot>
    <tbody>
    <!--<tr>
        <td>Tiger Nixon</td>
        <td>System Architect</td>
        <td>Edinburgh</td>
        <td>61</td>
        <td>2011/04/25</td>
        <td>$320,800</td>
    </tr>
    <tr>
        <td>Garrett Winters</td>
        <td>Accountant</td>
        <td>Tokyo</td>
        <td>63</td>
        <td>2011/07/25</td>
        <td>$170,750</td>
    </tr>-->
    </tbody>
</table>