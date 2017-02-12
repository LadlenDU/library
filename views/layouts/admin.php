<?php

/* @var $this app\core\View */
/* @var $values app\core\Container */

use app\helpers\Html;
use app\core\Config;
use app\core\Csrf;
use app\widgets\Navbar;

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="<?php Html::h(Config::inst()->globalEncoding) ?>"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-param" content="<?php echo Csrf::inst()->getCsrfTokenName() ?>">
    <meta name="csrf-token" content="<?php echo Csrf::inst()->getCsrfToken() ?>">

    <title><?php echo $this->title ?></title>
    <link href="/favicon.ico" rel="icon" type="image/x-icon"/>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
          integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link media="all" type="text/css" rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <!-- Datatable -->
    <!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.13/datatables.min.css"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css"/>-->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.bootstrap.min.css"/>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs-3.3.7/dt-1.10.13/datatables.min.js"></script>

    <link rel="stylesheet" href="<?php Html::mkLnk('/css/admin.css') ?>">
    <?php echo $this->css ?>

    <script type="text/javascript">
        // <![CDATA[

        /** @type {namespace} - Общий объект приложения. */
        var app = {};

        // ]]>
    </script>

</head>
<body>

<noscript>
    <div class="container noscript"><h2>Включите, пожалуйста, JavaScript</h2></div>
</noscript>

<div id="content_wrapper" style="display: none">

    <div class="container">
        <?php
        echo Navbar::headerPanel((isset($_GET['action']) ? $_GET['action'] : 'publishers'));
        echo $values->content
        ?>
    </div>

</div>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>

<script src="<?php Html::mkLnk('/js/helper.js') ?>"></script>
<?php echo $this->js ?>

<script type="text/javascript">
    $(function () {
        $('#content_wrapper').show();
    });
</script>

</body>
</html>
