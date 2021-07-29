<?php
$library = new App\Libraries\Library;
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('jenis_pengajuan', 'active') ?>' onclick="document.location='<?= base_url('jenis_pengajuan') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data Jenis pengajuan</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('jenis_pengajuan/tambah', 'active') ?>' onclick="document.location='<?= base_url('jenis_pengajuan/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah Jenis pengajuan</div>
    </div>


    <?php
    if (isset($menu) && $menu == 'Ubah Jabatan') : ?>
        <div class='tabs-item d-flex align-items-center active' onclick="document.location='<?= current_url() ?>' ">
            <span class="material-icons-outlined">
                edit
            </span>
            <div class='margin-left-2'><?= $menu ?></div>
        </div>

    <?php endif; ?>
</div>