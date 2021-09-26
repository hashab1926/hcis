<?php
$library = new App\Libraries\Library;
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('provinsi', 'active') ?>' onclick="document.location='<?= base_url('provinsi') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data Provinsi</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('provinsi/tambah', 'active') ?>' onclick="document.location='<?= base_url('provinsi/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah Provinsi</div>
    </div>

    <?php
    if (isset($menu) && $menu == 'Ubah Provinsi') : ?>
        <div class='tabs-item d-flex align-items-center active' onclick="document.location='<?= current_url() ?>' ">
            <span class="material-icons-outlined">
                edit
            </span>
            <div class='margin-left-2'><?= $menu ?></div>
        </div>

    <?php endif; ?>

</div>