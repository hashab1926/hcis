<?php
$library = new App\Libraries\Library;
?>
<div class="card-header p-0">
    <ul class="nav nav-tabs padding-x-3 d-flex justify-content-between">
        <li class="nav-item">
            <a class="nav-link d-flex align-items-center" href="javascript:history.go(-1)">
                <span class="material-icons-outlined icon-primary text-primary">
                    arrow_back
                </span>
                <div class='margin-left-2 text-primary fweight-600'>Detail FBCJ</div>
            </a>
        </li>

        <div class='d-flex'>
            <li class="nav-item">
                <a class="nav-link" href="<?= base_url('rekap/fbcj/sub_detail/' . $fbcj->id) ?>">Rekapitulasi FBCJ Detail</a>
            </li>
        </div>
    </ul>
</div>