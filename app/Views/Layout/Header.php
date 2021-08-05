<?php
$credential = new App\Libraries\Credential();
$library = new App\Libraries\Library();
$credential = $credential->cekCredential();
$namaUser = $credential->nama_karyawan ?? 'HCIS';
?>
<header>
    <nav class="navbar navbar-expand navbar-light bg-white box-shadow">
        <div class="container-fluid ">
            <div class="d-flex d-flex justify-content-between w-100">
                <div class='d-flex w-100'>
                    <a href="#" class="burger-btn d-block margin-top-2">
                        <span class="material-icons-outlined icon-title">
                            menu
                        </span>
                    </a>
                    <?php if (isset($buat_pengajuan) and $buat_pengajuan == true) : ?>
                        <div clas='w-100'>
                            <div class='margin-left-5'>
                                <div class='text-md-2 fweight-600'>Buat pengajuan</div>
                                <div class='text-sm-4 text-muted'>silahkan pilih template jenis pengajuan</div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>

                <?php if (isset($buat_pengajuan) and $buat_pengajuan == true) :
                    $jenisPengajuan = $_GET['jenis_pengajuan'] ?? null;
                ?>
                    <div class='w-100'>
                        <fieldset class="form-group margin-top-2">
                            <select id="jenis_pengajuan" name='jenis_pengajuan' class='form-select'>
                                <option value="">- Pilih Jenis Pengajuan -</option>
                                <option value="perdin_luarkota" <?= $jenisPengajuan != null && $jenisPengajuan == 'perdin_luarkota' ? 'selected' : '' ?>>Surat Perjalanan Dinas Luar Kota</option>
                                <option value="perdin_dalamkota" <?= $jenisPengajuan != null && $jenisPengajuan == 'perdin_dalamkota' ? 'selected' : '' ?>>Surat Perjalanan Dinas Dalam Kota</option>
                                <option value="perdin_luarnegri" <?= $jenisPengajuan != null && $jenisPengajuan == 'perdin_luarnegri' ? 'selected' : '' ?>>Surat Perjalanan Dinas Luar Negri</option>

                                <option value="reimburse_faskom" <?= $jenisPengajuan != null && $jenisPengajuan == 'reimburse_faskom' ? 'selected' : '' ?>>Reimburse Fasilitas Komunikasi</option>
                                <option value="cuti_karyawan" <?= $jenisPengajuan != null && $jenisPengajuan == 'cuti_karyawan' ? 'selected' : '' ?>>Pengajuan Cuti Karyawan</option>
                                <option value="lembur_karyawan" <?= $jenisPengajuan != null && $jenisPengajuan == 'lembur_karyawan' ? 'selected' : '' ?>>Pengajuan Lembur Karyawan</option>

                            </select>
                        </fieldset>
                    </div>
                <?php endif; ?>

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
                                    <h6 class="mb-0 text-gray-600">Hi, <?= $namaUser ?></h6>
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
        </div>
    </nav>
</header>