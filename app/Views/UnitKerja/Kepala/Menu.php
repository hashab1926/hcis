<?php
$library = new App\Libraries\Library;
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('unit_kerja/kepala', 'active') ?>' onclick="document.location='<?= base_url('unit_kerja/kepala') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data Direktorat / kepala</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('unit_kerja/kepala/tambah', 'active') ?>' onclick="document.location='<?= base_url('unit_kerja/kepala/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah Direktur kepala</div>
    </div>

    <?php
    if (isset($menu) && $menu == 'Ubah Kepala') : ?>
        <div class='tabs-item d-flex align-items-center active' onclick="document.location='<?= current_url() ?>' ">
            <span class="material-icons-outlined">
                edit
            </span>
            <div class='margin-left-2'><?= $menu ?></div>
        </div>

    <?php endif; ?>

</div>