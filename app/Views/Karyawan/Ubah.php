<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('template/vendors/select2/select2.min.css') ?>">
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col">
        <?= $this->include('Karyawan/Menu') ?>
        <div class="" style="border-top-left-radius:0;">
            <div class="card-body padding-x-1 pt-0">
                <form id="karyawan-updatestore">
                    <div class="row">
                        <?php
                        $col = count($data) >= 3 ? 'col-lg-4' : 'col-lg-6';
                        foreach ($data as $list) :
                        ?>
                            <div class="<?= $col ?>">
                                <div class="card box-shadow">
                                    <div class="card-body padding-bottom-10">
                                        <div class='d-flex flex-column '>
                                            <!-- ICON -->
                                            <div class='text-center d-flex align-items-center flex-column'>
                                                <?php if ($list->foto == null) : ?>
                                                    <div class='avatars'>
                                                        <span class="material-icons-outlined text-muted" style="font-size:150px">
                                                            perm_identity
                                                        </span>
                                                    </div>
                                                <?php else : ?>
                                                    <img src="<?= base_url('media/karyawan/' . $list->id) ?>" width='170' height='150'>
                                                <?php endif; ?>
                                                <i class='text-muted'>hanya mendukung format file <code>.jpg</code> <code>.jpeg</code> <code>.png</code></i>
                                                <label class='btn btn-primary margin-top-2' for="btn-upload-<?= $list->id ?>">
                                                    <input type="file" data-id="<?= $list->id ?>" class='d-none fileupload' id="btn-upload-<?= $list->id ?>">
                                                    <div class='d-flex align-items-center'>
                                                        <span class="material-icons-outlined">
                                                            file_upload
                                                        </span>
                                                        <div class='margin-left-1 fweight-600'>Upload</div>
                                                    </div>
                                                </label>
                                            </div>
                                            <!-- ICON -->

                                            <div class='row margin-top-3'>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>NIP</label>
                                                    <div class="text-muted"><input type='text' name="nip[<?= $list->id ?>]" class='form-control custom-input-height' value="<?= $list->nip ?>" /></div>
                                                </div>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Nama Karyawan</label>
                                                    <div class="text-muted"><input type='text' name="nama_karyawan[<?= $list->id ?>]" class='form-control custom-input-height' value="<?= $list->nama_karyawan ?>" /></div>
                                                </div>
                                            </div>
                                            <div class='row margin-top-2'>

                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Pangkat</label>
                                                    <select name="id_pangkat[<?= $list->id ?>]" data-name="id_pangkat" id="pangkat_<?= $list->id ?>" class="w-100" data-selected="<?= $list->nama_pangkat ?>"></select>
                                                    <i class='text-muted'> pangkat sebelumnya : <code><?= $list->nama_pangkat ?></code></i>
                                                </div>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Jabatan</label>
                                                    <select name="id_jabatan[<?= $list->id ?>]" data-name="id_jabatan" id="jabatan_<?= $list->id ?>" class="w-100" data-selected="<?= $list->nama_jabatan ?>"></select>
                                                    <i class='text-muted'> jabatan sebelumnya : <code><?= $list->nama_jabatan ?></code></i>

                                                </div>
                                            </div>

                                            <div class='row margin-top-2'>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Kepala</label>
                                                    <select name="id_kepala[<?= $list->id ?>]" data-name="id_kepala" id="kepala_<?= $list->id ?>" class="w-100" data-selected="<?= $list->nama_kepala ?>"></select>
                                                    <i class='text-muted'> kepala sebelumnya : <code><?= $list->nama_kepala ?></code></i>

                                                </div>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Divisi</label>
                                                    <select name="id_divisi[<?= $list->id ?>]" data-name="id_divisi" id="divisi_<?= $list->id ?>" class="w-100" data-selected="<?= $list->nama_divisi ?>"></select>
                                                    <i class='text-muted'> divisi sebelumnya : <code><?= $list->nama_divisi ?></code></i>

                                                </div>

                                            </div>
                                            <div class='row margin-top-2'>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Bagian</label>
                                                    <select name="id_bagian[<?= $list->id ?>]" data-name="id_bagian" id="bagian_<?= $list->id ?>" class="w-100" data-selected="<?= $list->nama_bagian ?>"></select>
                                                    <i class='text-muted'> bagian sebelumnya : <code><?= $list->nama_bagian ?></code></i>
                                                </div>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Email</label>
                                                    <div class="text-muted"><input type='text' name="email[<?= $list->id ?>]" class='form-control custom-input-height' value="<?= $list->email ?>" /></div>
                                                </div>
                                            </div>
                                            <?php if ($list->id_user != null) : ?>
                                                <input type="hidden" readonly name="id_user[<?= $list->id ?>]" value="<?= $list->id_user ?>">
                                                <div class='row margin-top-2'>
                                                    <div class='col-lg-6 col-xl-6 col-md-6 col-xs-6 margin-top-2'>
                                                        <label class='fweight-700'>Username</label>
                                                        <div class="text-muted"><input type='text' readonly disabled class='form-control custom-input-height' value="<?= $list->username ?>"></div>

                                                    </div>
                                                    <div class='col-lg-6 col-xl-6 col-md-6 col-xs-6 margin-top-2'>
                                                        <label class='fweight-700'>Password</label>
                                                        <div class="text-muted"><input placeholder='' type='password' name="password[<?= $list->id ?>]" class='form-control custom-input-height' value="" /></div>
                                                        <i class='text-muted'> kosongkan password jika tidak ingin diubah</i>

                                                    </div>
                                                </div>

                                                <div class='row margin-top-2'>
                                                    <div class='col-12 margin-top-2'>
                                                        <label class='fweight-700'>Level</label>
                                                        <select name="level[<?= $list->id ?>]" data-name="level" class="w-100 form-select custom-input-height" required>
                                                            <option value="">- Pilih Level Akun -</option>
                                                            <option value="1" <?= $list->level == '1' ? 'selected' : ''; ?>>Karyawan Biasa</option>
                                                            <option value="2" <?= $list->level == '2' ? 'selected' : ''; ?>>Admin Divisi</option>
                                                            <option value="3" <?= $list->level == '3' ? 'selected' : ''; ?>>Kepala Divisi</option>
                                                            <option value="4" <?= $list->level == '4' ? 'selected' : ''; ?>>Admin IT</option>
                                                            <option value="5" <?= $list->level == 'DIR' ? 'selected' : ''; ?>>Direktur</option>

                                                        </select>

                                                    </div>
                                                </div>

                                            <?php else : ?>
                                                <div class='row margin-top-5'>
                                                    <div class="col text-center">
                                                        <div class='text-md-2 fweight-600'>Belum memiliki akun</div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>

                    </div>
                    <!-- BTN SIMPAN -->
                    <div class='position-fixed' style="bottom:50px; right:35px;">
                        <button class='btn btn-primary d-flex align-items-center padding-x-4 padding-y-3 rounded-pill box-shadow' type="submit" name="ubah">
                            <span class="material-icons-outlined">
                                edit
                            </span>
                            <div class='margin-left-2 fweight-700'>Terapkan</div>
                        </button>
                    </div>
                    <!-- BTN SIMPAN -->
                </form>

            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section('js_files') ?>
<script src="<?= base_url('template/vendors/select2/select2.min.js') ?>"></script>
<script src="<?= base_url('js/Karyawan/UbahKaryawanSelect2.js') ?>"></script>
<script src="<?= base_url('js/Karyawan/UbahKaryawan.js') ?>"></script>

<?= $this->endSection() ?>