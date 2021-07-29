<?php
$library = new App\Libraries\Library;
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('unit_kerja/divisi', 'active') ?>' onclick="document.location='<?= base_url('unit_kerja/divisi') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data Divisi</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('unit_kerja/divisi/tambah', 'active') ?>' onclick="document.location='<?= base_url('unit_kerja/divisi/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah Divisi</div>
    </div>

    <?php
    if (isset($menu) && $menu == 'Ubah Divisi') : ?>
        <div class='tabs-item d-flex align-items-center active' onclick="document.location='<?= current_url() ?>' ">
            <span class="material-icons-outlined">
                edit
            </span>
            <div class='margin-left-2'><?= $menu ?></div>
        </div>

    <?php endif; ?>

</div>