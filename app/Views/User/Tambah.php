<?= $this->extend('Layout/Page') ?>

<?= $this->section('css_files') ?>
<link rel="stylesheet" href="<?= base_url('css/tabs-items.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<?php

$accessName = strpos(current_url(), 'direktorat') ? 'direktorat' : 'karyawan';
?>
<div class="row">
    <div class="col">
        <?= $this->include('Karyawan/Menu') ?>
        <div class="" style="border-top-left-radius:0;">
            <div class="card-body padding-x-1 pt-0">
                <form id='form-buatuser'>
                    <div class="row">
                        <input type="hidden" name='menu' value="<?= $menu ?>">
                        <?php
                        $col = count($data) >= 3 ? 'col-lg-4' : 'col-lg-6';
                        foreach ($data as $list) :
                        ?>
                            <div class="<?= $col ?>">
                                <div class="card box-shadow">
                                    <div class="card-body">
                                        <div class='d-flex flex-column '>
                                            <!-- ICON -->
                                            <div class='text-center'>
                                                <span class="material-icons-outlined text-muted" style="font-size:150px">
                                                    perm_identity
                                                </span>
                                            </div>
                                            <!-- ICON -->

                                            <div class='row'>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>NIP</label>
                                                    <div class="text-muted"><?= $list->nip ?></div>
                                                </div>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Nama Lengkap</label>
                                                    <div class="text-muted"><?= $list->nama_karyawan ?></div>
                                                </div>
                                            </div>
                                            <div class='row margin-top-2'>

                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Pangkat</label>
                                                    <div class="text-muted"><?= $list->nama_pangkat ?></div>
                                                </div>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'><?= $accessName == 'direktorat' ? 'Direktorat' : 'Jabatan' ?></label>
                                                    <div class="text-muted"><?= $accessName == 'direktorat' ?  $list->nama_kepala : $list->nama_jabatan ?></div>
                                                </div>
                                            </div>

                                            <?php if ($list->status != '3') : ?>
                                                <div class='row margin-top-2'>
                                                    <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                        <label class='fweight-700'>Kepala</label>
                                                        <div class="text-muted"><?= $list->nama_kepala ?? 'Belum diisi' ?></div>
                                                    </div>
                                                    <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                        <label class='fweight-700'>Divisi</label>
                                                        <div class="text-muted"><?= $list->nama_divisi ?? 'Belum diisi' ?></div>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                            <div class='row margin-top-2'>
                                                <?php if ($list->status != '3') : ?>
                                                    <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                        <label class='fweight-700'>Bagian</label>
                                                        <div class="text-muted"><?= $list->nama_bagian ?></div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12 margin-top-2'>
                                                    <label class='fweight-700'>Email</label>
                                                    <div class="text-muted"><?= $list->email ?></div>
                                                </div>
                                            </div>

                                        </div>

                                    </div>
                                    <div class="card-footer padding-top-4 padding-bottom-7">
                                        <?php if ($list->id_user != null) : ?>
                                            <div class="row">
                                                <div class="col text-center">

                                                    <span class='text-md-2 text-success'>Telah memiliki akun</span>
                                                </div>
                                            </div>

                                        <?php else : ?>
                                            <input type="hidden" readonly value="<?= $list->id ?>" name="id_karyawan[<?= $list->id ?>]" required />
                                            <div class='row'>

                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12'>
                                                    <label class='fweight-700'>Username</label>
                                                    <div class="text-muted"><input type='text' name="username[<?= $list->id ?>]" placeholder="Username" class='form-control custom-input-height' requried> </div>
                                                    <i class="text-muted">isi kolom <code>username</code> dengan benar</i>
                                                </div>
                                                <div class='col-lg-6 col-xl-6 col-md-12 col-xs-12'>
                                                    <label class='fweight-700'>Password</label>
                                                    <div class="text-muted"><input type='password' name="password[<?= $list->id ?>]" placeholder="Password" class='form-control custom-input-height' required> </div>

                                                </div>
                                            </div>

                                            <div class="row margin-top-5">
                                                <div class='col'>
                                                    <label class="fweight-700">Level</label>
                                                    <select name="level[<?= $list->id ?>]" data-name="level" class="w-100 form-select custom-input-height" id="level" required>
                                                        <option value="">- Pilih Level Akun -</option>
                                                        <option value="1">Karyawan Biasa</option>
                                                        <option value="2">Admin Divisi</option>
                                                        <option value="3">Kepala Divisi</option>
                                                        <option value="4">Admin IT</option>
                                                        <option value="DIR">Direktur</option>

                                                    </select>
                                                    <i class="text-muted">pilih Akses <code>level akun</code> dengan sbenar</i>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <!-- BTN SIMPAN -->
                    <div class='position-fixed' style="bottom:50px; right:35px;">
                        <button class='btn btn-success d-flex align-items-center padding-x-4 padding-y-3 rounded-pill box-shadow' type="submit" name="submit">
                            <span class="material-icons-outlined">
                                person_add
                            </span>
                            <div class='margin-left-2 fweight-700'>SIMPAN</div>
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
<script src="<?= base_url('js/User/BuatUser.js') ?>"></script>

<?= $this->endSection() ?>