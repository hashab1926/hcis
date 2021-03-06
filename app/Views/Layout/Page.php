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

        #loading-page {
            display: none;
        }
    </style>
</head>

<body>

    <div id='loading-page'>
        <div class='position-fixed' style="left:0; width:100%; height:100vh; background:#111; opacity:0.9; z-index:19111999"></div>
        <div class='position-fixed d-flex flex-column' style="left:50%; top:45%; transform: translate(-50%, -50%); z-index:19112000">
            <div>
                <img src="<?= base_url('img/logo.png') ?>" width="300">
            </div>
            <div class='text-center'>
                <img src="<?= base_url('img/loading-dot.svg') ?>" width=100 class='mx-auto d-block'>
            </div>
            <div class='text-white text-center text-md-3 fweight-500' style='font-family:Arial'>
                Sedang memproses
            </div>
        </div>
    </div>

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