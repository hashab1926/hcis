<?php
$library = new App\Libraries\Library;
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('bussiness_trans', 'active') ?>' onclick="document.location='<?= base_url('bussiness_trans') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data Bussiness Trans</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('bussiness_trans/tambah', 'active') ?>' onclick="document.location='<?= base_url('bussiness_trans/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah Bussiness Trans</div>
    </div>


    <?php
    if (isset($menu) && $menu == 'Ubah Bussiness Trans') : ?>
        <div class='tabs-item d-flex align-items-center active' onclick="document.location='<?= current_url() ?>' ">
            <span class="material-icons-outlined">
                edit
            </span>
            <div class='margin-left-2'><?= $menu ?></div>
        </div>

    <?php endif; ?>
</div>