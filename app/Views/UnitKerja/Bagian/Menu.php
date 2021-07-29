<?php
$library = new App\Libraries\Library;
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('unit_kerja/bagian', 'active') ?>' onclick="document.location='<?= base_url('unit_kerja/bagian') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data Bagian</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('unit_kerja/bagian/tambah', 'active') ?>' onclick="document.location='<?= base_url('unit_kerja/bagian/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah Bagian</div>
    </div>

    <?php
    if (isset($menu) && $menu == 'Ubah Bagian') : ?>
        <div class='tabs-item d-flex align-items-center active' onclick="document.location='<?= current_url() ?>' ">
            <span class="material-icons-outlined">
                edit
            </span>
            <div class='margin-left-2'><?= $menu ?></div>
        </div>

    <?php endif; ?>

</div>