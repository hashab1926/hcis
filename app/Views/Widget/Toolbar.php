<div class='position-fixed toolbar fixed-center' id="toolbar-table" style="bottom:-200px">
    <div class='bg-dark rounded-pill padding-x-7 padding-y-4 box-shadow'>
        <div class='d-flex align-items-center text-white'>
            <div class='d-flex'>
                <div id="count-item-selected" class='badge bg-muted2 rounded-pill padding-x-2'>3</div>
                <div class='margin-left-2 text-md-1 fweight-600'>item dipilih</div>
            </div>

            <?php
            if (!isset($except))
                $except = [];
            if (!in_array('detail', $except)) : ?>
                <!-- DETAIL -->
                <div class='margin-left-4'>
                    <button class='btn bg-muted2 text-white rounded-pill padding-x-4 padding-y-2 d-flex align-items-center' id='toolbar-detail'>
                        <span class="material-icons-outlined">
                            assignment_ind
                        </span>
                        <div class='margin-left-1 fweight-700'>Detail</div>
                    </button>
                </div>
                <!-- DETAIL -->
            <?php endif; ?>

            <?php if (!in_array('ubah', $except)) : ?>
                <!-- UBAH -->
                <div class='margin-left-2'>
                    <button class='btn bg-muted2 text-white rounded-pill padding-x-4 padding-y-2 d-flex align-items-center' id='toolbar-ubah'>
                        <span class="material-icons-outlined">
                            edit
                        </span>
                        <div class='margin-left-1 fweight-700'>Ubah</div>
                    </button>
                </div>
                <!-- UBAH -->
            <?php endif; ?>


            <?php if (!in_array('buat_akun', $except)) : ?>
                <!-- UBAH -->
                <div class='margin-left-2'>
                    <button class='btn btn-success text-white rounded-pill padding-x-4 padding-y-2 d-flex align-items-center' id='toolbar-buatakun'>
                        <span class="material-icons-outlined">
                            person_add
                        </span>
                        <div class='margin-left-1 fweight-700'>Buat Akun</div>
                    </button>
                </div>
                <!-- UBAH -->
            <?php endif; ?>

            <!-- HAPUS -->
            <div class='margin-left-2'>
                <button class='btn btn-danger text-white rounded-pill padding-x-4 padding-y-2 d-flex align-items-center' id='toolbar-hapus'>
                    <span class="material-icons-outlined">
                        delete_outline
                    </span>
                    <div class='margin-left-1 fweight-700'>Hapus</div>
                </button>
            </div>
            <!-- HAPUS -->

        </div>
    </div>
</div>