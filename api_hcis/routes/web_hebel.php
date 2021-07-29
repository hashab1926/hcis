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
$router->post('jenis_pengajuan/preview[/{id}]', 'JenisPengajuanController@preview');
$router->get('jenis_pengajuan/template_input[/{id}]', 'JenisPengajuanController@getInputTemplate');


$router->post('auth_login', 'LoginController@authLogin');
$router->get('cek_credential', 'CredentialController@cekCredential');

$router->group(['middleware' => 'AuthLogin'], function () use ($router) {

    // karyawan
    $router->get('karyawan', 'KaryawanController@index');
    $router->post('karyawan', 'KaryawanController@store');
    $router->delete('karyawan[/{id}]', 'KaryawanController@delete');
    $router->post('karyawan/multiple_delete', 'KaryawanController@multipleDelete');
    $router->put('karyawan[/{id}]', 'KaryawanController@update');


    // jabatan
    $router->get('jabatan', 'JabatanController@index');
    $router->post('jabatan', 'JabatanController@store');
    $router->delete('jabatan[/{id}]', 'JabatanController@delete');
    $router->post('jabatan/multiple_delete', 'JabatanController@multipleDelete');
    $router->put('jabatan[/{id}]', 'JabatanController@update');


    // jenis_pengajuan
    $router->get('jenis_pengajuan', 'JenisPengajuanController@index');
    $router->post('jenis_pengajuan', 'JenisPengajuanController@store');
    $router->delete('jenis_pengajuan[/{id}]', 'JenisPengajuanController@delete');
    $router->put('jenis_pengajuan[/{id}]', 'JenisPengajuanController@update');


    // pangkat
    $router->get('pangkat', 'PangkatController@index');
    $router->post('pangkat', 'PangkatController@store');
    $router->delete('pangkat[/{id}]', 'PangkatController@delete');
    $router->post('pangkat/multiple_delete', 'PangkatController@multipleDelete');
    $router->put('pangkat[/{id}]', 'PangkatController@update');


    $router->group(['namespace' => 'PerjalananDinas'], function () use ($router) {
        $router->get('perdin_business_trans', 'BussinessTransController@index');
        $router->post('perdin_business_trans', 'BussinessTransController@store');
        $router->delete('perdin_business_trans[/{id}]', 'BussinessTransController@delete');
        $router->put('perdin_business_trans[/{id}]', 'BussinessTransController@update');

        $router->get('perdin_cost_center', 'CostCenterController@index');
        $router->post('perdin_cost_center', 'CostCenterController@store');
        $router->delete('perdin_cost_center[/{id}]', 'CostCenterController@delete');
        $router->put('perdin_cost_center[/{id}]', 'CostCenterController@update');

        $router->get('perdin_jenis_pekerjaan', 'JenisPekerjaanController@index');
        $router->post('perdin_jenis_pekerjaan', 'JenisPekerjaanController@store');
        $router->delete('perdin_jenis_pekerjaan[/{id}]', 'JenisPekerjaanController@delete');
        $router->put('perdin_jenis_pekerjaan[/{id}]', 'JenisPekerjaanController@update');

        $router->get('perdin_wbs_element', 'WbsElementController@index');
        $router->post('perdin_wbs_element', 'WbsElementController@store');
        $router->delete('perdin_wbs_element[/{id}]', 'WbsElementController@delete');
        $router->put('perdin_wbs_element[/{id}]', 'WbsElementController@update');
    });


    $router->group(['namespace' => 'UnitKerja'], function () use ($router) {
        $router->get('unit_kerja_kepala', 'KepalaController@index');
        $router->post('unit_kerja_kepala', 'KepalaController@store');
        $router->delete('unit_kerja_kepala[/{id}]', 'KepalaController@delete');
        $router->put('unit_kerja_kepala[/{id}]', 'KepalaController@update');

        $router->get('unit_kerja_divisi', 'DivisiController@index');
        $router->post('unit_kerja_divisi', 'DivisiController@store');
        $router->delete('unit_kerja_divisi[/{id}]', 'DivisiController@delete');
        $router->put('unit_kerja_divisi[/{id}]', 'DivisiController@update');

        $router->get('unit_kerja_bagian', 'BagianController@index');
        $router->post('unit_kerja_bagian', 'BagianController@store');
        $router->delete('unit_kerja_bagian[/{id}]', 'BagianController@delete');
        $router->put('unit_kerja_bagian[/{id}]', 'BagianController@update');
    });


    $router->post('pengajuan', 'PengajuanController@store');

    $router->get('user', 'UserController@index');
    $router->post('user', 'UserController@store');
    $router->delete('user[/{id}]', 'UserController@delete');
    $router->put('user[/{id}]', 'UserController@update');
});
