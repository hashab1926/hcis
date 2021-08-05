<?php
$library = new App\Libraries\Library;
$accessDetail = [
    $library->activeIfRoutes('PengajuanController/detail', 'active'),
];
// printr($accessDetail);
$accessLampiran = [
    $library->activeIfRoutes('PengajuanController/ubahPengajuan', 'active'),
];
?>
<div class="card-header p-0">
    <ul class="nav nav-tabs padding-x-3 d-flex justify-content-between">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="javascript:history.go(-1)">
                <span class="material-icons-outlined icon-primary text-primary">
                    arrow_back
                </span>
                <div class='margin-left-2 text-primary fweight-600'><?= $nama_jenis ?? '' ?></div>
            </a>
        </li>

        <div class='d-flex'>
            <?php
            if (isset($pengajuan) && ($_nama_jenis == 'PD_LKOTA' || $_nama_jenis == 'PD_DKOTA' || $_nama_jenis == 'PD_LNGRI')) :
                if ($pengajuan->id_unit_kerja_divisi == $user->id_unit_kerja_divisi && $user->level == '2') :
                    if ($pengajuan->status == 'ACC' || $pengajuan->status_edit == 'Y') : ?>
                        <li class="nav-item">
                            <a class="nav-link <?= in_array('active', $accessLampiran) ? 'active'  : '' ?>" href="<?= base_url('pengajuan/detail/ubah/' . $pengajuan->id) ?>">Lampiran</a>
                        </li>

                    <?php elseif ($pengajuan->status == 'SELESAI' && ($pengajuan->status_edit == 'N' || $pengajuan->status_edit == 'PENDING')) : ?>
                        <li class="nav-item">
                            <a class="nav-link d-flex align-items-center " href="#" id="lock-lampiran" name='btnajuan' data-nama="<?= $library->ucFirst($penandatangan->nama_divisi) ?>" data-id="<?= $pengajuan->id ?>">
                                <span class="material-icons-outlined text-muted">
                                    lock
                                </span>
                                <div class='text-muted'>Lampiran</div>
                            </a>
                        </li>
                    <?php endif; ?>
                <?php endif; ?>

                <li class="nav-item">
                    <a class="nav-link <?= in_array('active', $accessDetail) ? 'active'  : '' ?>" href="<?= base_url('pengajuan/detail/' . $pengajuan->id) ?>">Detail</a>
                </li>
            <?php endif; ?>


        </div>


    </ul>
</div>