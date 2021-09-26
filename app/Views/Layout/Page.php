<?php
$routes = service('routes');

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta id='csrf_token' name="<?= csrf_token() ?>" content="<?= csrf_hash() ?>">

    <title>Vertical Navbar - </title>

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('template/css/bootstrap.css') ?>">

    <link rel="stylesheet" href="<?= base_url('template/vendors/perfect-scrollbar/perfect-scrollbar.css') ?>">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('template/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/vendors/sweetalert2/sweetalert2.min.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/css/custom.css') ?>">

    <?= $this->renderSection('css_files') ?>

    <link rel="shortcut icon" href="<?= base_url('template/images/favicon.svg') ?>" type="image/x-icon">
    <style>
        .sidebar-wrapper .menu .sidebar-item.active .sidebar-link {
            background: #212529;
        }
    </style>
</head>

<body>
    <div id="app">
        <?= $this->include('Layout/Sidebar'); ?>
        <div id="main" class='layout-navbar'>
            <?= $this->include('Layout/Header'); ?>
            <div <?= isset($full_page) && $full_page == true ? '' : "id='main-content'"; ?>>

                <?= $this->renderSection('content') ?>

                <!-- ?= $this->include('Layout/Footer') ?> -->
            </div>
        </div>


    </div>
    <script src="<?= base_url('template/vendors/perfect-scrollbar/perfect-scrollbar.min.js') ?>"></script>
    <script src="<?= base_url('template/js/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?= base_url('template/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= base_url('template/js/bootstrap.min.js') ?>"></script>

    <script src="<?= base_url('template/vendors/sweetalert2/sweetalert2.all.min.js') ?>"></script>

    <script src="<?= base_url('js/Config.js') ?>"></script>

    <?= $this->renderSection('js_files') ?>
    <script src="<?= base_url('template/js/main.js') ?>"></script>
</body>

</html>