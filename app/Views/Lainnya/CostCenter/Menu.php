<?php
$library = new App\Libraries\Library;
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('cost_center', 'active') ?>' onclick="document.location='<?= base_url('cost_center') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data Cost Center</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('cost_center/tambah', 'active') ?>' onclick="document.location='<?= base_url('cost_center/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah Cost Center</div>
    </div>


    <?php
    if (isset($menu) && $menu == 'Ubah Cost Center') : ?>
        <div class='tabs-item d-flex align-items-center active' onclick="document.location='<?= current_url() ?>' ">
            <span class="material-icons-outlined">
                edit
            </span>
            <div class='margin-left-2'><?= $menu ?></div>
        </div>

    <?php endif; ?>
</div>