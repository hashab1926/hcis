<?php
$session = session();
// printr($session->getFlashdata('pesan'));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Mazer Admin Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('template/css/bootstrap.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/vendors/bootstrap-icons/bootstrap-icons.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/css/app.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/css/pages/auth.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/css/custom.css') ?>">
    <link rel="stylesheet" href="<?= base_url('template/vendors/sweetalert2/sweetalert2.min.css') ?>">
</head>

<body>
    <div id="auth">
        <div class="container">
            <div class="row h-100">
                <div class="col-lg-7 col-12">
                    <div id="auth-left">
                        <div class="auth-logo">
                            <img src="<?= base_url('template/images/logo/logo.png') ?>" style="width:100px; height:50px">
                        </div>
                        <h1 class="auth-title">Login</h1>

                        <p class="auth-subtitle mb-5">Silahkan masukan username dan password anda </p>

                        <form action="" id="store-login" autocomplete="off">
                            <input type="hidden" reqdonly name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id='csrf_token'>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="text" class="form-control form-control-xl" name="username" placeholder="Username">
                                <div class="form-control-icon">
                                    <i class="bi bi-person"></i>
                                </div>
                            </div>
                            <div class="form-group position-relative has-icon-left mb-4">
                                <input type="password" class="form-control form-control-xl" name="password" placeholder="Password">
                                <div class="form-control-icon">
                                    <i class="bi bi-shield-lock"></i>
                                </div>
                            </div>

                            <button class="btn btn-primary btn-block btn-lg shadow-lg" type="submit" name='login'>Log in</button>
                        </form>

                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block">
                    <div class="margin-top-10 d-none d-xl-block d-lg-block">
                        <br /><br /><br /><br /><br /><br /><br />
                        <img src="<?= base_url('img/undraw-work.svg') ?>" class="margin-top-10 img-fluid d-block mx-auto" width="700">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="<?= base_url('js/Config.js') ?>"></script>
    <script src="<?= base_url('template/js/jquery-3.6.0.min.js') ?>"></script>
    <script src="<?= base_url('template/vendors/sweetalert2/sweetalert2.all.min.js') ?>"></script>
    <script src="<?= base_url('js/Login.js') ?>"></script>
    <?= $session->getFlashdata('pesan'); ?>
</body>

</html>