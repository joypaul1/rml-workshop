<!doctype html>
<html lang="en" class="color-sidebar sidebarcolor4  headercolor8">

<head>
    <title>COLLECTION-APPS | RML</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="cache-control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="pragma" content="no-cache">
    <meta http-equiv="expires" content="0">
    <!--favicon-->
    <link rel="icon" href="<?php echo $basePath ?>/assets/images/favicon-32x32.png" type="image/png">
    <!--plugins-->
    <link href="<?php echo $basePath ?>/assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet">
    <link href="<?php echo $basePath ?>/assets/plugins/simplebar/css/simplebar.css" rel="stylesheet">
    <link href="<?php echo $basePath ?>/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <link href="<?php echo $basePath ?>/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet">
    <!-- loader-->
    <link href="<?php echo $basePath ?>/assets/css/pace.min.css" rel="stylesheet">
    <script src="<?php echo $basePath ?>/assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="<?php echo $basePath ?>/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo $basePath ?>/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="../../../css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="<?php echo $basePath ?>/assets/css/app.css" rel="stylesheet">
    <link href="<?php echo $basePath ?>/assets/css/icons.css" rel="stylesheet">
    <!-- Theme Style CSS -->
    <!-- <link rel="stylesheet" href="<?php echo $basePath ?>/assets/css/dark-theme.css"> -->
    <!-- <link rel="stylesheet" href="<?php echo $basePath ?>/assets/css/semi-dark.css"> -->
    <link rel="stylesheet" href="<?php echo $basePath ?>/assets/css/header-colors.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.8/sweetalert2.min.css"
        integrity="sha512-y4S4cBeErz9ykN3iwUC4kmP/Ca+zd8n8FDzlVbq5Nr73gn1VBXZhpriQ7avR+8fQLpyq4izWm0b8s6q4Vedb9w==" crossorigin="anonymous"
        referrerpolicy="no-referrer">
    <?php
    if (isset($dynamic_link_css) && count($dynamic_link_css) > 0) {
    foreach ($dynamic_link_css as $key => $linkCss) {
            echo "<link rel='stylesheet' type='text/css' href='$linkCss'>";
        }
    }
    ?>

</head>