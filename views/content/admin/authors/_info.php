<?php

/* @var $this app\core\View */
/* @var $values app\core\Container */

$this->css .= '<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">';
$this->js .= '<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>';

?>
<script>
    $(function () {
        $("#datepicker").datepicker({dateFormat: 'd MM, yy', changeMonth: true, changeYear: true, yearRange: "-120:+0"});
    });
</script>
<input type="text" name="first_name" placeholder="Имя">
<input type="text" name="last_name" placeholder="Фамилия">
<input type="text" name="birthday" id="datepicker" placeholder="День рождения">
