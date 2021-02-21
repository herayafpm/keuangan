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
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Home::index');
$routes->group('api', ['filter' => 'auth_admin', 'namespace' => '\App\Controllers\Api'], function ($routes) {
	$routes->resource('siswa', ['only' => ['index', 'create'], 'controller' => 'Siswa']);
	$routes->group('transaksi/(:num)/laporan', ['namespace' => '\App\Controllers\Api'], function ($routes) {
		$routes->post('', 'LaporanTransaksi::excel/$1');
	});
});
$routes->group('auth', ['namespace' => '\App\Controllers\Auth'], function ($routes) {
	$routes->get('login', 'Login::index');
	$routes->post('login', 'Login::index');
	$routes->get('logout', 'Logout::index');
});
$routes->group('siswa', ['filter' => 'auth_siswa', 'namespace' => '\App\Controllers\Siswa'], function ($routes) {
	$routes->get('', 'Dashboard::index');
	$routes->get('dashboard', 'Dashboard::index');
	$routes->group('log', function ($routes) {
		$routes->get('', 'Log::index');
		$routes->post('datatable', 'Log::datatable');
	});
	$routes->group(
		'transaksi',
		['namespace' => '\App\Controllers\Siswa\Transaksi', 'filter' => 'auth_siswa'],
		function ($routes) {
			$routes->group('(:num)', function ($routes) {
				$routes->get('', 'RiwayatTransaksi::index/$1');
				$routes->post('datatable', 'RiwayatTransaksi::datatable/$1');
				$routes->group('pembayaran/(:num)', function ($routes) {
					$routes->get('', 'RiwayatPembayaran::index/$1/$2');
					$routes->post('datatable', 'RiwayatPembayaran::datatable/$1/$2');
				});
			});
		}
	);
});
$routes->group(
	'admin',
	['filter' => 'auth_admin', 'namespace' => '\App\Controllers\Admin'],
	function ($routes) {
		$routes->get('', 'Dashboard::index');
		$routes->get('dashboard', 'Dashboard::index');
		$routes->group('profile', function ($routes) {
			$routes->get('', 'Profile::index');
			$routes->post('', 'Profile::index');
		});
		$routes->group('log', function ($routes) {
			$routes->get('', 'Log::index');
			$routes->post('datatable', 'Log::datatable');
		});
		$routes->group('admin', function ($routes) {
			$routes->get('', 'Admin::index');
			$routes->post('datatable', 'Admin::datatable');
			$routes->group('tambah', function ($routes) {
				$routes->get('', 'Admin::tambah');
				$routes->post('', 'Admin::tambah');
			});
			$routes->group('ubah', function ($routes) {
				$routes->get('(:num)', 'Admin::ubah/$1');
				$routes->post('(:num)', 'Admin::ubah/$1');
			});
			$routes->get('hapus/(:num)', 'Admin::hapus/$1');
			$routes->group('log', function ($routes) {
				$routes->get('(:num)', 'Admin::log/$1');
				$routes->post('(:num)/datatable', 'Admin::log_datatable/$1');
			});
		});
		$routes->group('siswa', function ($routes) {
			$routes->get('', 'Siswa::index');
			$routes->get('import_excel', 'Siswa::import_excel');
			$routes->post('datatable', 'Siswa::datatable');
			$routes->group('tambah', function ($routes) {
				$routes->get('', 'Siswa::tambah');
				$routes->post('', 'Siswa::tambah');
			});
			$routes->group('ubah', function ($routes) {
				$routes->get('(:num)', 'Siswa::ubah/$1');
				$routes->post('(:num)', 'Siswa::ubah/$1');
			});
			$routes->get('hapus/(:num)', 'Siswa::hapus/$1');
			$routes->group('log', function ($routes) {
				$routes->get('(:num)', 'Siswa::log/$1');
				$routes->post('(:num)/datatable', 'Siswa::log_datatable/$1');
			});
		});
		$routes->group('jenis_transaksi', function ($routes) {
			$routes->get('', 'JenisTransaksi::index');
			$routes->post('datatable', 'JenisTransaksi::datatable');
			$routes->group('tambah', function ($routes) {
				$routes->get('', 'JenisTransaksi::tambah');
				$routes->post('', 'JenisTransaksi::tambah');
			});
			$routes->group('ubah', function ($routes) {
				$routes->get('(:num)', 'JenisTransaksi::ubah/$1');
				$routes->post('(:num)', 'JenisTransaksi::ubah/$1');
			});
			$routes->get('hapus/(:num)', 'JenisTransaksi::hapus/$1');
		});
		$routes->group(
			'transaksi',
			['namespace' => '\App\Controllers\Admin\Transaksi', 'filter' => 'auth_admin:2'],
			function ($routes) {
				$routes->get('', 'Transaksi::index');
				$routes->post('', 'Transaksi::index');
				$routes->group('(:num)', function ($routes) {
					$routes->get('', 'RiwayatTransaksi::index/$1');
					$routes->post('datatable', 'RiwayatTransaksi::datatable/$1');
					$routes->group('laporan', function ($routes) {
						$routes->get('', 'LaporanTransaksi::index/$1');
						$routes->post('datatable', 'LaporanTransaksi::datatable/$1');
					});
					$routes->group('pembayaran/(:num)', function ($routes) {
						$routes->get('', 'RiwayatPembayaran::index/$1/$2');
						$routes->post('datatable', 'RiwayatPembayaran::datatable/$1/$2');
						$routes->get('print_nota/(:num)', 'RiwayatPembayaran::print_nota/$1/$2/$3');
						$routes->group('tambah', function ($routes) {
							$routes->get('', 'RiwayatPembayaran::tambah/$1/$2');
							$routes->post('', 'RiwayatPembayaran::tambah/$1/$2');
						});
					});
				});
			}
		);
	}
);

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
