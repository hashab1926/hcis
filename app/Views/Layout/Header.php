<?php
$credential = new App\Libraries\Credential();
$library = new App\Libraries\Library();
$credential = $credential->cekCredential();
$namaUser = $credential->nama_karyawan ?? 'HCIS';
?>
<header>
    <nav class="navbar navbar-expand navbar-light bg-white box-shadow">
        <div class="container-fluid">
            <a href="#" class="burger-btn d-block margin-top-2">
                <span class="material-icons-outlined icon-title">
                    menu
                </span>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item dropdown me-1">
                        <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bi bi-envelope bi-sub fs-4 text-gray-600'></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <h6 class="dropdown-header">Mail</h6>
                            </li>
                            <li><a class="dropdown-item" href="#">No new mail</a></li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown me-3">
                        <a class="nav-link active dropdown-toggle" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class='bi bi-bell bi-sub fs-4 text-gray-600'></i>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                            <li>
                                <h6 class="dropdown-header">Notifications</h6>
                            </li>
                            <li><a class="dropdown-item">No notification available</a></li>
                        </ul>
                    </li>
                </ul>

                <div class="dropdown">
                    <a href="#" data-bs-toggle="dropdown" aria-expanded="false">
                        <div class="user-menu d-flex">
                            <div class="user-name text-end me-3">
                                <h6 class="mb-0 text-gray-600"><?= $namaUser ?></h6>
                                <p class="mb-0 text-sm text-gray-600"><?= $library->ucFirst($credential->nama_jabatan) ?></p>
                            </div>
                            <div class="user-img d-flex align-items-center">
                                <div class="avatar avatar-md">
                                    <span class="material-icons-outlined icon-title text-muted">
                                        account_circle
                                    </span>
                                </div>
                            </div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                        <li><a class="dropdown-item" href="<?= base_url('logout') ?>"><i class="icon-mid bi bi-box-arrow-left me-2"></i> Logout</a></li>
                    </ul>
                </div>


            </div>


        </div>
    </nav>
</header>



<?php
$pengajuan = $library->activeIf('pengajuan/tambah', 'yes');
if ($pengajuan == 'yes') : ?>

    <div class='position-fixed bg-dark box-shadow' id="sidebar-right-pengajuan" style=" right:0px; z-index:9999; height:100vh; top:0; width:300px; transition:all 0.5s;">

        <div class='position-fixed' id="button_showhide" style="bottom:50%; right:300px;  z-index:9999;  transition:all 0.5s;">
            <button class='btn btn-dark btn-sm padding-y-2 box-shadow no-border-radius'>
                <span class="material-icons-outlined" id='icon-showhide'>
                    chevron_left
                </span>
            </button>
        </div>
        <div class='padding-x-3 padding-y-3 d-flex text-white'>
            <span class="material-icons-outlined icon-lg-title">
                dashboard
            </span>
            <div class='d-flex flex-column padding-left-2'>
                <div class='fweight-600 text-md-1'>List Pengajuan</div>
                <div class='text-muted text-sm-4'>pilih pengajuan</div>
            </div>
        </div>

        <div class='d-flex flex-column text-white'>
            <div class='padding-y-2 padding-x-4 d-flex align-items-start jenis_pengajuan hover-pointer' data-value="perdin_luarkota">
                <div>
                    <span class="material-icons-outlined">
                        dashboard
                    </span>
                </div>
                <div class='margin-left-2 text-sm-4'>Perjalanan Dinas Luar Kota</div>
            </div>
            <div class='padding-y-2 padding-x-4 d-flex align-items-start jenis_pengajuan hover-pointer' data-value="perdin_dalamkota">
                <div>
                    <span class="material-icons-outlined">
                        dashboard
                    </span>
                </div>
                <div class='margin-left-2 text-sm-4'>Perjalanan Dinas Dalam Kota</div>
            </div>
            <div class='padding-y-2 padding-x-4 d-flex align-items-start jenis_pengajuan hover-pointer' data-value="perdin_luarnegri">
                <div>
                    <span class="material-icons-outlined">
                        dashboard
                    </span>
                </div>
                <div class='margin-left-2 text-sm-4'>Perjalanan Dinas Luar Negri</div>
            </div>
            <div class='padding-y-2 padding-x-4 d-flex align-items-start jenis_pengajuan hover-pointer' data-value="reimburse_faskom">
                <div>
                    <span class="material-icons-outlined">
                        dashboard
                    </span>
                </div>
                <div class='margin-left-2 text-sm-4'>Reimburse Fasilitas Komunikasi</div>
            </div>
            <div class='padding-y-2 padding-x-4 d-flex align-items-start jenis_pengajuan hover-pointer' data-value="cuti_karyawan">
                <div>
                    <span class="material-icons-outlined">
                        dashboard
                    </span>
                </div>
                <div class='margin-left-2 text-sm-4'>Cuti Karyawan</div>
            </div>
            <div class='padding-y-2 padding-x-4 d-flex align-items-start jenis_pengajuan hover-pointer' data-value="lembur_karyawan">
                <div>
                    <span class="material-icons-outlined">
                        dashboard
                    </span>
                </div>
                <div class='margin-left-2 text-sm-4'>Lembur Karyawan</div>
            </div>
        </div>
    </div>

<?php endif; ?>