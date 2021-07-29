<?php $input = $_GET;
$library = new App\Libraries\Library();
if (isset($input['jenis_pengajuan']) || isset($template_input)) : ?>

    <div class='position-fixed toolbar fixed-center' id="toolbar-template" style="bottom:0px">
        <div class='bg-dark rounded-pill padding-x-7 padding-y-4'>
            <div class='d-flex align-items-center text-white'>
                <div class='d-flex'>
                    <div class='margin-left-2 text-md-1 fweight-600'><?= $nama_jenis ?? '' ?></div>
                </div>


                <!-- ISI SURAT-->
                <div class='margin-left-2'>
                    <button class='btn bg-muted2 text-white rounded-pill padding-x-4 padding-y-2 d-flex align-items-center box-shadow' id='toolbar-isisurat'>
                        <span class="material-icons-outlined">
                            edit
                        </span>
                        <div class='margin-left-1 fweight-700'>Isi surat</div>
                    </button>
                </div>
                <!-- ISI SURAT-->

                <?php if ($library->cariKeywordTemplate($template_input, 'Biaya Perjalanan Dinas')) : ?>
                    <div class='margin-left-2'>
                        <button class='btn bg-muted2 text-white rounded-pill padding-x-4 padding-y-2 d-flex align-items-center box-shadow' data-toggle="modal" data-target="#modal-rincian" id='toolbar-isirincian'>
                            <span class="material-icons-outlined">
                                attach_money
                            </span>
                            <div class='margin-left-1 fweight-700'>Isi Rincian biaya</div>
                        </button>
                    </div>
                <?php endif; ?>

                <!-- HAPUS -->
                <div class='margin-left-2'>
                    <button class='btn btn-primary text-white rounded-pill padding-x-4 padding-y-2 d-flex align-items-center box-shadow' id='toolbar-simpan'>
                        <span class="material-icons-outlined">
                            save
                        </span>
                        <div class='margin-left-1 fweight-700'>Simpan</div>
                    </button>
                </div>
                <!-- HAPUS -->

            </div>
        </div>
    </div>

    <div class="sidebar-right isi-surat">
        <div class="sidebar-header">
            <div class='d-flex justify-content-between'>
                <div class='d-flex'>
                    <div class='margin-top-1'>
                        <span class="material-icons-outlined text-white icon-title">
                            edit
                        </span>
                    </div>
                    <div class='margin-left-2 text-white'>
                        <div class='fweight-600 text-md-2'>Input Surat</div>
                        <div class='text-sm-4'> silahkan isi template input surat</div>
                    </div>

                </div>

                <div class='text-white'>
                    <a href="#" id='close-isi-surat' class='text-white text-md-3'>&times;</a>
                </div>
            </div>
        </div>

        <div class="sidebar-body padding-bottom-7" style="height:90vh; overflow:auto">
            <form id='templating-store'>
                <?php
                foreach ($template_input as $list) :
                    if ($list->tipe == 'Table') continue;
                ?>

                    <?= base64_decode($list->display) ?>
                <?php endforeach; ?>
            </form>
        </div>
    </div>



    <?php if ($library->cariKeywordTemplate($template_input, 'Biaya Perjalanan Dinas')) : ?>

        <div class="modal fade" id="modal-rincian" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header" style=" background:var(--Bg-muted2); ">
                        <h5 class="modal-title text-white">Rincian Biaya Perjalanan dinas</h5>
                        <button type="button" class="btn btn-success text-md-1 fweight-700 text-whites" data-dismiss="modal" id='simpan-rincian-biaya'>
                            SIMPAN
                        </button>
                    </div>
                    <div class="modal-body">
                        <form id='form-rincianbiaya'>
                            <?= $library->displayKeywordTemplate($template_input, 'Biaya Perjalanan Dinas'); ?>
                        </form>
                    </div>

                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>