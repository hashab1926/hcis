<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('LoginController');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'LoginController::index');

$routes->get('dashboard', 'DashboardController::index');
$routes->get('login', 'LoginController::index');
$routes->get('logout', 'LoginController::logout');
$routes->post('login/store', 'LoginController::store');

$routes->group('/', ['filter' => 'authlogin'], function ($routes) {
	$routes->get('user/buat/(:segment)', 'UserController::tambah/$1');
	$routes->get('user/direktorat/buat/(:segment)', 'UserController::tambah/$1');

	$routes->post('user/buat/store', 'UserController::store');
	$routes->get('akun/tambah', 'UserController::tambah');
	$routes->get('user/ajax/data_nregister_karyawan', 'UserController::ajaxDataNotResigterKaryawan');
	$routes->post('user/store', 'UserController::store');

	$routes->get('direktorat', 'KaryawanController::indexDirektorat');
	$routes->get('direktorat/get_datatable', 'KaryawanController::getDatatableDirektorat');
	$routes->get('direktorat/ubah/(:segment)', 'KaryawanController::ubah/$1');

	$routes->get('karyawan', 'KaryawanController::index');
	$routes->get('karyawan/get_datatable', 'KaryawanController::getDatatable');
	$routes->get('karyawan/get', 'KaryawanController::get');

	$routes->get('karyawan/tambah', 'KaryawanController::tambah');
	$routes->get('direktorat/tambah', 'KaryawanController::tambahDirektorat');
	$routes->post('karyawan/store', 'KaryawanController::store');
	$routes->post('karyawan/hapus', 'KaryawanController::hapus');
	$routes->get('karyawan/detail/(:segment)', 'KaryawanController::detail/$1');
	$routes->get('karyawan/ubah/(:segment)', 'KaryawanController::ubah/$1');
	$routes->post('karyawan/ubah/store', 'KaryawanController::ubahStore');
	$routes->get('karyawan/ajax/data_pejabat', 'KaryawanController::ajaxDataPejabat');
	$routes->get('karyawan/ajax/data_karyawan', 'KaryawanController::ajaxDataKaryawan');
	$routes->get('media/karyawan/(:num)', 'KaryawanController::fotoKaryawan/$1');

	$routes->get('jabatan', 'JabatanController::index');
	$routes->get('jabatan/get_datatable', 'JabatanController::getDatatable');
	$routes->get('jabatan/tambah', 'JabatanController::tambah');
	$routes->post('jabatan/store', 'JabatanController::store');
	$routes->post('jabatan/hapus', 'JabatanController::hapus');
	$routes->get('jabatan/ubah/(:segment)', 'JabatanController::ubah/$1');
	$routes->post('jabatan/ubah/store', 'JabatanController::ubahStore');
	$routes->get('jabatan/ajax/data_jabatan', 'JabatanController::ajaxDataJabatan');
	$routes->get('jabatan/ajax/data_jabatan/(:num)', 'JabatanController::ajaxDataJabatan/$1');


	$routes->get('pangkat', 'PangkatController::index');
	$routes->get('pangkat/get_datatable', 'PangkatController::getDatatable');
	$routes->get('pangkat/tambah', 'PangkatController::tambah');
	$routes->post('pangkat/store', 'PangkatController::store');
	$routes->get('pangkat/ajax/data_pangkat', 'PangkatController::ajaxDataPangkat');
	$routes->get('pangkat/ubah/(:segment)', 'PangkatController::ubah/$1');
	$routes->post('pangkat/hapus', 'PangkatController::hapus');
	$routes->post('pangkat/ubah/store', 'PangkatController::ubahStore');

	$routes->get('provinsi', 'ProvinsiController::index');
	$routes->get('provinsi/get_datatable', 'ProvinsiController::getDatatable');
	$routes->get('provinsi/tambah', 'ProvinsiController::tambah');
	$routes->post('provinsi/store', 'ProvinsiController::store');
	$routes->get('provinsi/ajax/data_provinsi', 'ProvinsiController::ajaxDataProvinsi');
	$routes->get('provinsi/ajax/data_provinsi_nama', 'ProvinsiController::ajaxDataProvinsiNama');
	$routes->get('provinsi/ubah/(:segment)', 'ProvinsiController::ubah/$1');
	$routes->post('provinsi/hapus', 'ProvinsiController::hapus');
	$routes->post('provinsi/ubah/store', 'ProvinsiController::ubahStore');

	$routes->get('jenis_pengajuan', 'JenisPengajuanController::index');
	$routes->get('jenis_pengajuan/get_datatable', 'JenisPengajuanController::getDatatable');
	$routes->get('jenis_pengajuan/tambah', 'JenisPengajuanController::tambah');
	$routes->post('jenis_pengajuan/store', 'JenisPengajuanController::store');
	$routes->get('jenis_pengajuan/lihat/(:num)', 'JenisPengajuanController::lihatTemplate/$1');
	$routes->get('jenis_pengajuan/ajax/data_jenis', 'JenisPengajuanController::ajaxDataJenis');

	$routes->get('cost_center', 'Lainnya\CostCenterController::index');
	$routes->get('cost_center/get_datatable', 'Lainnya\CostCenterController::getDatatable');
	$routes->get('cost_center/tambah', 'Lainnya\CostCenterController::tambah');
	$routes->post('cost_center/store', 'Lainnya\CostCenterController::store');
	$routes->post('cost_center/hapus', 'Lainnya\CostCenterController::hapus');
	$routes->get('cost_center/ubah/(:segment)', 'Lainnya\CostCenterController::ubah/$1');
	$routes->post('cost_center/ubah/store', 'Lainnya\CostCenterController::ubahStore');
	$routes->get('cost_center/ajax/data_costcenter', 'Lainnya\CostCenterController::ajaxDataCostCenter');
	$routes->get('cost_center/ajax/data_costcenter_kode', 'Lainnya\CostCenterController::ajaxDataCostCenterKode');

	$routes->get('jenis_fasilitas', 'Lainnya\JenisFasilitasController::index');
	$routes->get('jenis_fasilitas/get_datatable', 'Lainnya\JenisFasilitasController::getDatatable');
	$routes->get('jenis_fasilitas/tambah', 'Lainnya\JenisFasilitasController::tambah');
	$routes->post('jenis_fasilitas/store', 'Lainnya\JenisFasilitasController::store');
	$routes->post('jenis_fasilitas/hapus', 'Lainnya\JenisFasilitasController::hapus');
	$routes->get('jenis_fasilitas/ubah/(:segment)', 'Lainnya\JenisFasilitasController::ubah/$1');
	$routes->post('jenis_fasilitas/ubah/store', 'Lainnya\JenisFasilitasController::ubahStore');
	$routes->get('jenis_fasilitas/ajax/data_jenis_fasilitas', 'Lainnya\JenisFasilitasController::ajaxDataCostCenter');
	$routes->get('jenis_fasilitas/ajax/data_jenis_fasilitas_nama', 'Lainnya\JenisFasilitasController::ajaxDataJenisFasilitasNama');

	$routes->get('bussiness_trans', 'Lainnya\BussinessTransController::index');
	$routes->get('bussiness_trans/get_datatable', 'Lainnya\BussinessTransController::getDatatable');
	$routes->get('bussiness_trans/tambah', 'Lainnya\BussinessTransController::tambah');
	$routes->post('bussiness_trans/store', 'Lainnya\BussinessTransController::store');
	$routes->post('bussiness_trans/hapus', 'Lainnya\BussinessTransController::hapus');
	$routes->get('bussiness_trans/ubah/(:segment)', 'Lainnya\BussinessTransController::ubah/$1');
	$routes->post('bussiness_trans/ubah/store', 'Lainnya\BussinessTransController::ubahStore');
	$routes->get('bussiness_trans/ajax/data_bussinesstrans', 'Lainnya\BussinessTransController::ajaxDataBussinessTrans');
	$routes->get('bussiness_trans/ajax/data_bussinesstrans_kode', 'Lainnya\BussinessTransController::ajaxDataBussinessTransKode');

	$routes->get('wbs_element', 'Lainnya\WbsElementController::index');
	$routes->get('wbs_element/get_datatable', 'Lainnya\WbsElementController::getDatatable');
	$routes->get('wbs_element/tambah', 'Lainnya\WbsElementController::tambah');
	$routes->post('wbs_element/store', 'Lainnya\WbsElementController::store');
	$routes->post('wbs_element/hapus', 'Lainnya\WbsElementController::hapus');
	$routes->get('wbs_element/ubah/(:segment)', 'Lainnya\WbsElementController::ubah/$1');
	$routes->post('wbs_element/ubah/store', 'Lainnya\WbsElementController::ubahStore');
	$routes->get('wbs_element/ajax/data_wbselement', 'Lainnya\WbsElementController::ajaxDataWbsElement');
	$routes->get('wbs_element/ajax/data_wbselement_kode', 'Lainnya\WbsElementController::ajaxDataWbsElementKode');


	$routes->get('negara', 'Lainnya\NegaraController::index');
	$routes->get('negara/get_datatable', 'Lainnya\NegaraController::getDatatable');
	$routes->get('negara/tambah', 'Lainnya\NegaraController::tambah');
	$routes->post('negara/store', 'Lainnya\NegaraController::store');
	$routes->post('negara/hapus', 'Lainnya\NegaraController::hapus');
	$routes->get('negara/ubah/(:segment)', 'Lainnya\NegaraController::ubah/$1');
	$routes->post('negara/ubah/store', 'Lainnya\NegaraController::ubahStore');
	$routes->get('negara/ajax/data_negara', 'Lainnya\NegaraController::ajaxDataNegara');
	$routes->get('negara/ajax/data_namanegara', 'Lainnya\NegaraController::ajaxDataNamaNegara');

	$routes->get('pengajuan', 'PengajuanController::index');
	$routes->get('pengajuan/saya', 'PengajuanController::indexSaya');
	$routes->get('pengajuan/detail/(:num)', 'PengajuanController::detail/$1');
	$routes->get('pengajuan/preview/(:num)', 'PengajuanController::preview/$1');
	$routes->get('pengajuan/tambah', 'PengajuanController::tambah');
	$routes->get('pengajuan/get_datatable', 'PengajuanController::getDatatable');
	$routes->get('pengajuan/get_datatable_saya', 'PengajuanController::getDatatableSaya');
	$routes->post('pengajuan/store', 'PengajuanController::store');
	$routes->post('pengajuan/lampiran/store', 'PengajuanController::storeLampiran');
	$routes->get('pengajuan/inbox', 'InboxPengajuanController::index');
	$routes->get('pengajuan/detail/ubah/(:num)', 'PengajuanController::ubahPengajuan/$1');
	$routes->get('pengajuan/inbox/get_datatable', 'InboxPengajuanController::getDatatable');
	$routes->post('pengajuan/storeacc', 'PengajuanController::storeAcc');
	$routes->post('pengajuan/storeajuan', 'PengajuanController::storeAjuan');
	$routes->post('pengajuan/storeaccajuan', 'PengajuanController::storeAccAjuan');
	$routes->post('pengajuan/storebatal', 'PengajuanController::storeBatal');

	$routes->get('lampiran_pengajuan/preview/(:num)', 'PengajuanController::previewLampiran/$1');
	$routes->get('lampiran_pengajuan/preview_pengajuan/(:num)', 'PengajuanController::previewLampiranPengajuan/$1');
	$routes->group('unit_kerja', function ($routes) {
		$routes->get('kepala', 'UnitKerja\KepalaController::index');
		$routes->post('kepala/store', 'UnitKerja\KepalaController::store');
		$routes->post('kepala/hapus', 'UnitKerja\KepalaController::hapus');
		$routes->get('kepala/ubah/(:segment)', 'UnitKerja\KepalaController::ubah/$1');
		$routes->post('kepala/ubah/store', 'UnitKerja\KepalaController::ubahStore');
		$routes->get('kepala/get_datatable', 'UnitKerja\KepalaController::getDatatable');
		$routes->get('kepala/tambah', 'UnitKerja\KepalaController::tambah');
		$routes->get('kepala/ajax/data_kepala', 'UnitKerja\KepalaController::ajaxDataKepala');

		$routes->get('divisi', 'UnitKerja\DivisiController::index');
		$routes->post('divisi/store', 'UnitKerja\DivisiController::store');
		$routes->post('divisi/hapus', 'UnitKerja\DivisiController::hapus');
		$routes->get('divisi/ubah/(:segment)', 'UnitKerja\DivisiController::ubah/$1');
		$routes->post('divisi/ubah/store', 'UnitKerja\DivisiController::ubahStore');
		$routes->get('divisi/get_datatable', 'UnitKerja\DivisiController::getDatatable');
		$routes->get('divisi/tambah', 'UnitKerja\DivisiController::tambah');
		$routes->get('divisi/ajax/data_divisi', 'UnitKerja\DivisiController::ajaxDataDivisi');
		$routes->get('divisi/ajax/data_divisi/(:num)', 'UnitKerja\DivisiController::ajaxDataDivisi/$1');


		$routes->get('bagian', 'UnitKerja\BagianController::index');
		$routes->post('bagian/store', 'UnitKerja\BagianController::store');
		$routes->post('bagian/hapus', 'UnitKerja\BagianController::hapus');
		$routes->get('bagian/ubah/(:segment)', 'UnitKerja\BagianController::ubah/$1');
		$routes->post('bagian/ubah/store', 'UnitKerja\BagianController::ubahStore');
		$routes->get('bagian/get_datatable', 'UnitKerja\BagianController::getDatatable');
		$routes->get('bagian/tambah', 'UnitKerja\BagianController::tambah');
		$routes->get('bagian/ajax/data_bagian', 'UnitKerja\BagianController::ajaxDataBagian');
		$routes->get('bagian/ajax/data_bagian/(:num)', 'UnitKerja\BagianController::ajaxDataBagian/$1');
		// $routes->get('bagian', 'UnitKerja\BagianController::index');
		// $routes->get('bagian/get_datatable', 'UnitKerja\BagianController::getDatatable');
		// $routes->get('bagian/tambah', 'UnitKerja\BagianController::tambah');
		// $routes->post('bagian/store', 'UnitKerja\BagianController::store');
	});
	$routes->group('rekap', function ($routes) {
		$routes->get('preview/(:segment)', 'Rekap\ReimburseFaskomController::preview/$1');
		$routes->get('preview_perdin', 'Rekap\PerdinController::preview');
		$routes->get('preview_perdin/(:segment)', 'Rekap\PerdinController::preview/$1');

		$routes->get('reimburse_faskom', 'Rekap\ReimburseFaskomController::index');
		$routes->get('perdin', 'Rekap\PerdinController::index');
		$routes->get('perdin/get_datatable', 'Rekap\PerdinController::getDatatable');


		$routes->get('cuti_karyawan', 'Rekap\CutiKaryawanController::index');
		$routes->get('preview_cuti', 'Rekap\CutiKaryawanController::preview');
		$routes->get('preview_cuti/(:segment)', 'Rekap\CutiKaryawanController::preview/$1');

		$routes->get('fbcj', 'Rekap\FBCJController::index');
		$routes->get('fbcj_bukti/preview/(:num)/(:num)', 'Rekap\FBCJController::previewBukti/$1/$2');
		$routes->get('fbcj/ajax/data_fbcj/(:num)', 'Rekap\FBCJController::ajaxDataFbcj/$1');
		$routes->get('fbcj/detail/(:num)', 'Rekap\FBCJController::detail/$1');
		$routes->get('fbcj/sub_detail/(:num)', 'Rekap\FBCJController::subDetail/$1');
		$routes->get('fbcj/sub_detail/preview/(:num)', 'Rekap\FBCJController::previewSubDetail/$1');
		$routes->get('fbcj/preview/(:num)', 'Rekap\FBCJController::preview/$1');

		$routes->get('fbcj/buat', 'Rekap\FBCJController::buat');
		$routes->post('fbcj/store', 'Rekap\FBCJController::store');
		$routes->post('fbcj/sub_store', 'Rekap\FBCJController::subStore');
		$routes->get('fbcj/get_datatable', 'Rekap\FBCJController::getDatatable');
	});
});

// $routes->get('pangkat/ajax/data_pangkat', 'PangkatController::ajaxDataPangkat');
// $routes->get('pangkat/ubah/(:segment)', 'PangkatController::ubah/$1');
// $routes->post('pangkat/hapus', 'PangkatController::hapus');
// $routes->post('pangkat/ubah/store', 'PangkatController::ubahStore');



/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
