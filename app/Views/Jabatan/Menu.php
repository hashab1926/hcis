<?php
$library = new App\Libraries\Library;
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('jabatan', 'active') ?>' onclick="document.location='<?= base_url('jabatan') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data jabatan</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('jabatan/tambah', 'active') ?>' onclick="document.location='<?= base_url('jabatan/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah jabatan</div>
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