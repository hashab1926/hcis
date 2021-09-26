<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->post('auth_login', 'LoginController@authLogin');
$router->get('cek_credential', 'CredentialController@cekCredential');
$router->get('pengajuan', 'PengajuanController@index');
$router->group(['middleware' => 'AuthLogin'], function () use ($router) {

    // karyawan
    $router->get('karyawan', 'KaryawanController@index');
    $router->post('karyawan', 'KaryawanController@store');
    $router->delete('karyawan[/{id}]', 'KaryawanController@delete');
    $router->post('karyawan/multiple_delete', 'KaryawanController@multipleDelete');
    $router->post('karyawan/update[/{id}]', 'KaryawanController@update');

    // jabatan
    $router->get('jabatan', 'JabatanController@index');
    $router->post('jabatan', 'JabatanController@store');
    $router->delete('jabatan[/{id}]', 'JabatanController@delete');
    $router->post('jabatan/multiple_delete', 'JabatanController@multipleDelete');
    $router->put('jabatan[/{id}]', 'JabatanController@update');

    // provinsi
    $router->get('provinsi', 'ProvinsiController@index');
    $router->post('provinsi', 'ProvinsiController@store');
    $router->delete('provinsi[/{id}]', 'ProvinsiController@delete');
    $router->post('provinsi/multiple_delete', 'ProvinsiController@multipleDelete');
    $router->put('provinsi[/{id}]', 'ProvinsiController@update');

    // pangkat
    $router->get('pangkat', 'PangkatController@index');
    $router->post('pangkat', 'PangkatController@store');
    $router->delete('pangkat[/{id}]', 'PangkatController@delete');
    $router->post('pangkat/multiple_delete', 'PangkatController@multipleDelete');
    $router->put('pangkat[/{id}]', 'PangkatController@update');


    $router->group(['namespace' => 'Lainnya'], function () use ($router) {
        $router->get('bussiness_trans', 'BussinessTransController@index');
        $router->post('bussiness_trans', 'BussinessTransController@store');
        $router->delete('bussiness_trans[/{id}]', 'BussinessTransController@delete');
        $router->put('bussiness_trans[/{id}]', 'BussinessTransController@update');
        $router->post('bussiness_trans/multiple_delete', 'BussinessTransController@multipleDelete');

        $router->get('cost_center', 'CostCenterController@index');
        $router->post('cost_center', 'CostCenterController@store');
        $router->delete('cost_center[/{id}]', 'CostCenterController@delete');
        $router->post('cost_center/multiple_delete', 'CostCenterController@multipleDelete');
        $router->put('cost_center[/{id}]', 'CostCenterController@update');

        $router->get('jenis_fasilitas', 'JenisFasilitasController@index');
        $router->post('jenis_fasilitas', 'JenisFasilitasController@store');
        $router->delete('jenis_fasilitas[/{id}]', 'JenisFasilitasController@delete');
        $router->post('jenis_fasilitas/multiple_delete', 'JenisFasilitasController@multipleDelete');
        $router->put('jenis_fasilitas[/{id}]', 'JenisFasilitasController@update');

        $router->get('negara', 'NegaraController@index');
        $router->post('negara', 'NegaraController@store');
        $router->delete('negara[/{id}]', 'NegaraController@delete');
        $router->post('negara/multiple_delete', 'NegaraController@multipleDelete');
        $router->put('negara[/{id}]', 'NegaraController@update');

        $router->get('wbs_element', 'WbsElementController@index');
        $router->post('wbs_element', 'WbsElementController@store');
        $router->delete('wbs_element[/{id}]', 'WbsElementController@delete');
        $router->put('wbs_element[/{id}]', 'WbsElementController@update');
        $router->post('wbs_element/multiple_delete', 'WbsElementController@multipleDelete');
    });


    $router->group(['namespace' => 'UnitKerja'], function () use ($router) {
        $router->get('unit_kerja_kepala', 'KepalaController@index');
        $router->post('unit_kerja_kepala', 'KepalaController@store');
        $router->delete('unit_kerja_kepala[/{id}]', 'KepalaController@delete');
        $router->post('unit_kerja_kepala/multiple_delete', 'KepalaController@multipleDelete');
        $router->put('unit_kerja_kepala[/{id}]', 'KepalaController@update');

        $router->get('unit_kerja_divisi', 'DivisiController@index');
        $router->post('unit_kerja_divisi', 'DivisiController@store');
        $router->delete('unit_kerja_divisi[/{id}]', 'DivisiController@delete');
        $router->post('unit_kerja_divisi/multiple_delete', 'DivisiController@multipleDelete');
        $router->put('unit_kerja_divisi[/{id}]', 'DivisiController@update');

        $router->get('unit_kerja_bagian', 'BagianController@index');
        $router->post('unit_kerja_bagian', 'BagianController@store');
        $router->delete('unit_kerja_bagian[/{id}]', 'BagianController@delete');
        $router->post('unit_kerja_bagian/multiple_delete', 'BagianController@multipleDelete');
        $router->put('unit_kerja_bagian[/{id}]', 'BagianController@update');
    });


    // pengajuan

    $router->post('pengajuan', 'PengajuanController@store');
    $router->get('pengajuan/karyawan', 'PengajuanController@pengajuanKaryawanExists');

    $router->put('pengajuan[/{id}]', 'PengajuanController@update');
    $router->post('pengajuan/ubah_lampiran[/{id}]', 'PengajuanController@updateLampiran');

    // lampiran pengjauan
    $router->get('lampiran_pengajuan[/{idPengajuan}]', 'LampiranPengajuanController@index');

    $router->get('user', 'UserController@index');
    $router->post('user', 'UserController@store');
    $router->delete('user[/{id}]', 'UserController@delete');
    $router->put('user[/{id}]', 'UserController@update');

    // fbcj
    $router->get('fbcj', 'FbcjController@index');
    $router->get('fbcj_detail[/{idFbcj}]', 'FbcjController@detail');
    $router->get('fbcj_sub_detail[/{idFbcj}]', 'FbcjController@subDetail');
    $router->post('fbcj', 'FbcjController@store');
    $router->post('fbcj/sub_store[/{idFbcj}]', 'FbcjController@subStore');
    $router->get('fbcj_bukti[/{idFbcj}]', 'BuktiFbcjController@index');
});
