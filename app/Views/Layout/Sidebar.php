<?php
$library = new App\Libraries\Library;
$credential = new App\Libraries\Credential();
$level = $credential->get('level');

$accessKaryawan = [
    $library->activeIf('karyawan', 'active'),
    $library->activeIf('karyawan', 'text-white'),
    $library->activeIf('karyawan/tambah', 'active'),
    $library->activeIf('karyawan/tambah', 'text-white'),
    $library->activeIfRoutes('KaryawanController/detail', 'active'),
    $library->activeIfRoutes('KaryawanController/ubah', 'active')

];
$accessDirektorat = [
    $library->activeIf('direktorat', 'active'),
    $library->activeIf('direktorat', 'text-white'),
    $library->activeIf('direktorat/tambah', 'active'),
    $library->activeIf('direktorat/tambah', 'text-white'),
    $library->activeIfRoutes('KaryawanController/detail', 'active'),
    $library->activeIfRoutes('KaryawanController/ubah', 'active')

];

$accessJabatan = [
    $library->activeIf('jabatan', 'active'),
    $library->activeIf('jabatan', 'text-white'),
    $library->activeIf('jabatan/tambah', 'active'),
    $library->activeIf('jabatan/tambah', 'text-white'),
    $library->activeIfRoutes('JabatanController/ubah', 'active')
];

$accessJenisPengajuan = [
    $library->activeIf('jenis_pengajuan', 'active'),
    $library->activeIf('jenis_pengajuan', 'text-white'),
    $library->activeIf('jenis_pengajuan/tambah', 'active'),
    $library->activeIf('jenis_pengajuan/tambah', 'text-white'),
    $library->activeIfRoutes('JenisPengajuanController/ubah', 'active')
];

$accessPangkat = [
    $library->activeIf('pangkat', 'active'),
    $library->activeIf('pangkat', 'text-white'),
    $library->activeIf('pangkat/tambah', 'active'),
    $library->activeIf('pangkat/tambah', 'text-white'),
];

$accessProvinsi = [
    $library->activeIf('provinsi', 'active'),
    $library->activeIf('provinsi', 'text-white'),
    $library->activeIf('provinsi/tambah', 'active'),
    $library->activeIf('provinsi/tambah', 'text-white'),
];



$accessUnitKerja = [
    $library->activeIf('unit_kerja/kepala', 'active'),
    $library->activeIf('unit_kerja/kepala', 'text-white'),
    $library->activeIf('unit_kerja/kepala/tambah', 'active'),
    $library->activeIf('unit_kerja/kepala/tambah', 'text-white'),

    $library->activeIf('unit_kerja/divisi', 'active'),
    $library->activeIf('unit_kerja/divisi', 'text-white'),
    $library->activeIf('unit_kerja/divisi/tambah', 'active'),
    $library->activeIf('unit_kerja/divisi/tambah', 'text-white'),

    $library->activeIf('unit_kerja/bagian', 'active'),
    $library->activeIf('unit_kerja/bagian', 'text-white'),
    $library->activeIf('unit_kerja/bagian/tambah', 'active'),
    $library->activeIf('unit_kerja/bagian/tambah', 'text-white'),
];

$accessLainnya = [
    $library->activeIf('bussiness_trans', 'active'),
    $library->activeIf('bussiness_trans', 'text-white'),
    $library->activeIf('bussiness_trans/tambah', 'active'),
    $library->activeIf('bussiness_trans/tambah', 'text-white'),

    $library->activeIf('cost_center', 'active'),
    $library->activeIf('cost_center', 'text-white'),
    $library->activeIf('cost_center/tambah', 'active'),
    $library->activeIf('cost_center/tambah', 'text-white'),

    $library->activeIf('wbs_element', 'active'),
    $library->activeIf('wbs_element', 'text-white'),
    $library->activeIf('wbs_element/tambah', 'active'),
    $library->activeIf('wbs_element/tambah', 'text-white'),

    $library->activeIf('jenis_fasilitas', 'active'),
    $library->activeIf('jenis_fasilitas', 'text-white'),
    $library->activeIf('jenis_fasilitas/tambah', 'active'),
    $library->activeIf('jenis_fasilitas/tambah', 'text-white'),

    $library->activeIf('negara', 'active'),
    $library->activeIf('negara', 'text-white'),
    $library->activeIf('negara/tambah', 'active'),
    $library->activeIf('negara/tambah', 'text-white'),
];
$accessCostCenter = [
    $library->activeIf('cost_center', 'active'),
    $library->activeIf('cost_center', 'text-white'),
    $library->activeIf('cost_center/tambah', 'active'),
    $library->activeIf('cost_center/tambah', 'text-white'),
];

$accessBussinessTrans = [
    $library->activeIf('bussiness_trans', 'active'),
    $library->activeIf('bussiness_trans', 'text-white'),
    $library->activeIf('bussiness_trans/tambah', 'active'),
    $library->activeIf('bussiness_trans/tambah', 'text-white'),
];

$accessWbs = [
    $library->activeIf('wbs_element', 'active'),
    $library->activeIf('wbs_element', 'text-white'),
    $library->activeIf('wbs_element/tambah', 'active'),
    $library->activeIf('wbs_element/tambah', 'text-white'),
];

$accessJenisFasilitas = [
    $library->activeIf('jenis_fasilitas', 'active'),
    $library->activeIf('jenis_fasilitas', 'text-white'),
    $library->activeIf('jenis_fasilitas/tambah', 'active'),
    $library->activeIf('jenis_fasilitas/tambah', 'text-white'),
];

$accessKepala = [
    $library->activeIf('unit_kerja/kepala', 'active'),
    $library->activeIf('unit_kerja/kepala', 'text-white'),
    $library->activeIf('unit_kerja/kepala/tambah', 'active'),
    $library->activeIf('unit_kerja/kepala/tambah', 'text-white'),
];

$accessDivisi = [
    $library->activeIf('unit_kerja/divisi', 'active'),
    $library->activeIf('unit_kerja/divisi', 'text-white'),
    $library->activeIf('unit_kerja/divisi/tambah', 'active'),
    $library->activeIf('unit_kerja/divisi/tambah', 'text-white'),
];

$accessBagian = [
    $library->activeIf('unit_kerja/bagian', 'active'),
    $library->activeIf('unit_kerja/bagian', 'text-white'),
    $library->activeIf('unit_kerja/bagian/tambah', 'active'),
    $library->activeIf('unit_kerja/bagian/tambah', 'text-white'),
];
$accessPerdin = [
    $library->activeIf('rekap/perdin', 'active'),
    $library->activeIf('rekap/perdin', 'text-white'),
];
$accessDashboard = [
    $library->activeIf('dashboard', 'active'),
    $library->activeIf('dashboard', 'text-white'),
];

$accessJenisFasilitas = [
    $library->activeIf('jenis_fasilitas', 'active'),
    $library->activeIf('jenis_fasilitas', 'text-white'),
    $library->activeIf('jenis_fasilitas/tambah', 'active'),
    $library->activeIf('jenis_fasilitas/tambah', 'text-white'),
];

$accessNegara = [
    $library->activeIf('negara', 'active'),
    $library->activeIf('negara', 'text-white'),
    $library->activeIf('negara/tambah', 'active'),
    $library->activeIf('negara/tambah', 'text-white'),
];

$accessSemuaPengajuan = [
    $library->activeIf('pengajuan', 'active'),
];


$accessPengajuanSaya = [
    $library->activeIf('pengajuan/saya', 'active'),
];
$accessCutiKaryawan = [
    $library->activeIf('rekap/cutikaryawan', 'active'),
];

?>

<div id="sidebar" class="active">

    <!-- <div class="sidebar-header">
        <div class="d-flex justify-content-between">
            <div class="logo">
                <a href="index.html"><img src="assets/images/logo/logo.png" alt="Logo" srcset=""></a>
            </div>
            <div class="toggler">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div> -->

    <div class="sidebar-wrapper active box-shadow">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="d-flex flex-column">
                    <img src="<?= base_url('template/images/logo/logo.png') ?>" alt="Logo" class='d-block mx-auto' style="width:75px; height:40px;">
                    <div class='margin-left-2 text-md-1 margin-top-2 text-center text-primary'>Human Capital Information System</div>
                </div>
                <div class="toggler">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>


        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <?php if ($level == '2') : ?>

                    <li class="sidebar-item <?= in_array('active', $accessSemuaPengajuan) ? 'active'  : '' ?> ">
                        <a href="<?= base_url('pengajuan') ?>" class='sidebar-link <?= in_array('active', $accessSemuaPengajuan) ? 'text-white'  : '' ?>'>
                            <div class="material-icons-outlined">
                                badge
                            </div>
                            <span>Semua Pengajuan</span>
                        </a>
                    </li>
                    <li class="sidebar-item <?= in_array('active', $accessPengajuanSaya) ? 'active'  : '' ?>">
                        <a href="<?= base_url('pengajuan/saya') ?>" class='sidebar-link   <?= in_array('active', $accessPengajuanSaya) ? 'text-white'  : '' ?>'>
                            <div class="material-icons-outlined">
                                account_box
                            </div>
                            <span>Pengajuan Saya</span>
                        </a>
                    </li>
                    <li class="sidebar-item  has-sub <?= in_array('active', $accessUnitKerja) ? 'active'  : '' ?> ">
                        <a href="#" class='sidebar-link'>
                            <div class="material-icons-outlined <?= in_array('active', $accessUnitKerja) ? 'text-white'  : '' ?>">
                                summarize
                            </div>
                            <span>Rekapitulasi</span>
                        </a>
                        <ul class="submenu  has-sub <?= in_array('active', $accessUnitKerja) ? 'active'  : '' ?>">
                            <li class="submenu-item <?= in_array('active', $accessPerdin) ? 'active'  : '' ?>">
                                <a href="<?= base_url('rekap/perdin') ?>">Perjalanan Dinas</a>
                            </li>
                            <li class="submenu-item  <?= in_array('active', $accessDivisi) ? 'active'  : '' ?>">
                                <a href="<?= base_url('rekap/reimburse_faskom') ?>">Reimburse Faskom</a>
                            </li>
                            <li class="submenu-item  <?= in_array('active', $accessCutiKaryawan) ? 'active'  : '' ?>">
                                <a href="<?= base_url('rekap/cuti_karyawan') ?>">Cuti Karyawan</a>
                            </li>
                            <li class="submenu-item  <?= in_array('active', $accessDivisi) ? 'active'  : '' ?>">
                                <a href="<?= base_url('rekap/reimburse_faskom') ?>">Reimburse Faskom</a>
                            </li>

                        </ul>
                    </li>

                    <li class="sidebar-item  has-sub <?= in_array('active', $accessUnitKerja) ? 'active'  : '' ?> ">
                        <a href="#" class='sidebar-link'>
                            <div class="material-icons-outlined <?= in_array('active', $accessUnitKerja) ? 'text-white'  : '' ?>">
                                text_snippet
                            </div>
                            <span>Rekapitulasi FBCJ</span>
                        </a>
                        <ul class="submenu  has-sub <?= in_array('active', $accessUnitKerja) ? 'active'  : '' ?>">
                            <li class="submenu-item <?= in_array('active', $accessPerdin) ? 'active'  : '' ?>">
                                <a href="<?= base_url('rekap/fbcj') ?>" class='d-flex align-items-center'>
                                    <span class="material-icons-outlined">
                                        list
                                    </span>
                                    <div class='margin-left-2'>Rekap</div>
                                </a>
                            </li>
                            <li class="submenu-item  <?= in_array('active', $accessDivisi) ? 'active'  : '' ?>">
                                <a href="<?= base_url('rekap/fbcj/buat') ?>" class='d-flex align-items-center'>
                                    <span class="material-icons-outlined">
                                        add
                                    </span>
                                    <div class='margin-left-2'>Buat</div>
                                </a>
                            </li>

                        </ul>
                    </li>




                <?php elseif ($level == '1') : ?>


                    <li class="sidebar-item  ">
                        <a href="<?= base_url('pengajuan/saya') ?>" class='sidebar-link'>
                            <div class="material-icons-outlined">
                                account_box
                            </div>
                            <span>Pengajuan Saya</span>
                        </a>
                    </li>

                <?php elseif ($level == '3') : ?>
                    <li class="sidebar-item  ">
                        <a href="<?= base_url('pengajuan/inbox') ?>" class='sidebar-link'>
                            <div class="material-icons-outlined">
                                mail
                            </div>
                            <span>Inbox</span>
                        </a>
                    </li>

                    <li class="sidebar-item  ">
                        <a href="<?= base_url('pengajuan/saya') ?>" class='sidebar-link'>
                            <div class="material-icons-outlined">
                                account_box
                            </div>
                            <span>Pengajuan Saya</span>
                        </a>
                    </li>
                <?php elseif ($level == '4') : ?>
                    <li class="sidebar-title">Master</li>
                    <li class="sidebar-item <?= in_array('active', $accessDirektorat) ? 'active'  : '' ?> ">
                        <a href="<?= base_url('direktorat') ?>" class='sidebar-link'>
                            <div class="material-icons-outlined <?= in_array('active', $accessDirektorat) ? 'text-white'  : '' ?>">
                                contacts
                            </div>
                            <span>Direktorat </span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= in_array('active', $accessKaryawan) ? 'active'  : '' ?> ">
                        <a href="<?= base_url('karyawan') ?>" class='sidebar-link'>
                            <div class="material-icons-outlined <?= in_array('active', $accessKaryawan) ? 'text-white'  : '' ?>">
                                groups
                            </div>
                            <span>Karyawan </span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= in_array('active', $accessJabatan) ? 'active'  : '' ?>">
                        <a href="<?= base_url('jabatan') ?>" class='sidebar-link'>
                            <div class=" material-icons-outlined <?= in_array('active', $accessJabatan) ? 'text-white'  : '' ?>">
                                supervised_user_circle
                            </div>
                            <span>Jabatan</span>
                        </a>
                    </li>


                    <li class="sidebar-item <?= in_array('active', $accessProvinsi) ? 'active'  : '' ?>">
                        <a href="<?= base_url('provinsi') ?>" class='sidebar-link'>
                            <div class=" material-icons-outlined <?= in_array('active', $accessProvinsi) ? 'text-white'  : '' ?>">
                                apartment
                            </div>
                            <span>Provinsi</span>
                        </a>
                    </li>

                    <li class="sidebar-item <?= in_array('active', $accessPangkat) ? 'active'  : '' ?>">
                        <a href="<?= base_url('pangkat') ?>" class='sidebar-link'>
                            <div class="material-icons-outlined  <?= in_array('text-white', $accessPangkat) ? 'text-white'  : '' ?>">
                                workspace_premium
                            </div>
                            <span>Pangkat</span>
                        </a>
                    </li>

                    <li class="sidebar-item  has-sub <?= in_array('active', $accessUnitKerja) ? 'active'  : '' ?> ">
                        <a href="#" class='sidebar-link'>
                            <div class="material-icons-outlined <?= in_array('active', $accessUnitKerja) ? 'text-white'  : '' ?>">
                                account_tree
                            </div>
                            <span>Unit Kerja</span>
                        </a>
                        <ul class="submenu  has-sub <?= in_array('active', $accessUnitKerja) ? 'active'  : '' ?>">
                            <li class="submenu-item <?= in_array('active', $accessKepala) ? 'active'  : '' ?>">
                                <a href="<?= base_url('unit_kerja/kepala') ?>">Direktorat / Kepala</a>
                            </li>
                            <li class="submenu-item  <?= in_array('active', $accessDivisi) ? 'active'  : '' ?>">
                                <a href="<?= base_url('unit_kerja/divisi') ?>">Divisi</a>
                            </li>
                            <li class="submenu-item  <?= in_array('active', $accessBagian) ? 'active'  : '' ?>">
                                <a href="<?= base_url('unit_kerja/bagian') ?>">Bagian</a>
                            </li>

                        </ul>
                    </li>
                    <li class="sidebar-item  has-sub <?= in_array('active', $accessLainnya) ? 'active'  : '' ?> ">
                        <a href="#" class='sidebar-link'>
                            <div class="material-icons-outlined <?= in_array('active', $accessLainnya) ? 'text-white'  : '' ?>">
                                more_horiz
                            </div>
                            <span>Lainnya</span>
                        </a>
                        <ul class="submenu  has-sub <?= in_array('active', $accessLainnya) ? 'active'  : '' ?>">
                            <li class="submenu-item <?= in_array('active', $accessCostCenter) ? 'active'  : '' ?>">
                                <a href="<?= base_url('cost_center') ?>">Cost Center</a>
                            </li>
                            <li class="submenu-item  <?= in_array('active', $accessBussinessTrans) ? 'active'  : '' ?>">
                                <a href="<?= base_url('bussiness_trans') ?>">Bussiness Trans</a>
                            </li>
                            <li class="submenu-item  <?= in_array('active', $accessWbs) ? 'active'  : '' ?>">
                                <a href="<?= base_url('wbs_element') ?>">Wbs Element</a>
                            </li>
                            <li class="submenu-item  <?= in_array('active', $accessJenisFasilitas) ? 'active'  : '' ?>">
                                <a href="<?= base_url('jenis_fasilitas') ?>">Jenis Fasilitas</a>
                            </li>
                            <li class="submenu-item  <?= in_array('active', $accessNegara) ? 'active'  : '' ?>">
                                <a href="<?= base_url('negara') ?>">Negara</a>
                            </li>

                        </ul>
                    </li>

                <?php elseif ($level == 'DIR') : ?>

                    <li class="sidebar-item <?= in_array('active', $accessDashboard) ? 'active'  : '' ?>">
                        <a href="<?= base_url('dashboard') ?>" class='sidebar-link'>
                            <div class="material-icons-outlined  <?= in_array('text-white', $accessDashboard) ? 'text-white'  : '' ?>">
                                home
                            </div>
                            <span>Dashboard</span>
                        </a>
                    </li>
                    <li class="sidebar-item  ">
                        <a href="<?= base_url('pengajuan/inbox') ?>" class='sidebar-link'>
                            <div class="material-icons-outlined">
                                mail
                            </div>
                            <span>Inbox</span>
                        </a>
                    </li>



                <?php endif; ?>

                <?php
                $allowBuat = ['1', '2', '3'];
                if (in_array($level, $allowBuat)) : ?>

                    <li class="margin-top-5" style="list-style: none;">
                        <a href="<?= base_url('pengajuan/tambah') ?>" class="btn btn-primary btn-block fweight-700 padding-y-2 d-flex align-items-center justify-content-center box-shadow" style="border-radius:.5rem">
                            <span class="material-icons-outlined">
                                add
                            </span>
                            <div class='margin-left-1 text-md-1'>Buat Pengajuan</div>
                        </a>
                    </li>
                <?php endif; ?>

            </ul>
        </div>
        <button class="sidebar-toggler btn x"><i data-feather="x"></i></button>
    </div>
</div>