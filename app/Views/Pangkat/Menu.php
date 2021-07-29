<?php
$library = new App\Libraries\Library;
?>
<div class='data-tabs'>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('pangkat', 'active') ?>' onclick="document.location='<?= base_url('pangkat') ?>' ">
        <span class="material-icons-outlined">
            format_list_bulleted
        </span>
        <div class='margin-left-2'>Data pangkat</div>
    </div>
    <div class='tabs-item d-flex align-items-center <?= $library->activeIf('pangkat/tambah', 'active') ?>' onclick="document.location='<?= base_url('pangkat/tambah') ?>' ">
        <span class="material-icons-outlined">
            add
        </span>
        <div class='margin-left-2'>Tambah pangkat</div>
    </div>

    <?php
    if (isset($menu) && $menu == 'Ubah Pangkat') : ?>
        <div class='tabs-item d-flex align-items-center active' onclick="document.location='<?= current_url() ?>' ">
            <span class="material-icons-outlined">
                edit
            </span>
            <div class='margin-left-2'><?= $menu ?></div>
        </div>

    <?php endif; ?>

</div>