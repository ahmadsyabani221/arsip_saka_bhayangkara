<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
// Profil Routes
$route['profile'] = 'profile/index';  // Menampilkan halaman profil
$route['profile/update_password'] = 'profile/update_password';  // Proses perubahan password
$route['profile/update/(:num)'] = 'profile/update_profile/$1';  // Update profil berdasarkan ID
$route['profile/change_profile_picture'] = 'profile/change_profile_picture';  // Proses perubahan foto profil
$route['profile/forgot_password'] = 'profile/forgot_password';  // Menampilkan halaman lupa password
$route['profile/reset_password'] = 'profile/reset_password';  // Proses reset password

// Default routes
$route['default_controller'] = 'auth';
$route['dashboard'] = 'dashboard/index';  // Halaman dashboard utama

// User Management Routes
$route['user_management'] = 'user_management/index';  // Halaman utama manajemen user
$route['user_management/add'] = 'user_management/add';  // Menampilkan form tambah pengguna
$route['user_management/edit/(:num)'] = 'user_management/edit/$1';  // Menampilkan form edit pengguna berdasarkan ID
$route['user_management/delete/(:num)'] = 'user_management/delete/$1';  // Menghapus pengguna berdasarkan ID

// Arsip Management Routes
$route['arsip'] = 'arsip/index';  // Halaman arsip utama
$route['arsip/download/(:num)'] = 'arsip/download/$1';  // Download arsip berdasarkan ID
$route['arsip/kirim/(:num)'] = 'arsip/kirim/$1';  // Kirim arsip berdasarkan ID
$route['arsip/pilih_user/(:num)'] = 'arsip/pilih_user/$1';  // Pilih user untuk arsip
$route['arsip/proses_kirim/(:num)'] = 'arsip/proses_kirim/$1';  // Proses pengiriman arsip
$route['arsip/search'] = 'arsip/searchArsip';  // Pencarian arsip
$route['arsip/update_entries'] = 'arsip/updateEntries';  // Update jumlah entri yang ditampilkan
$route['arsip/view_file/(:any)'] = 'arsip/view_file/$1';  // Melihat file arsip berdasarkan nama
$route['arsip/create'] = 'arsip/create';  // Menambah arsip baru
$route['arsip/edit/(:num)'] = 'arsip/edit/$1';  // Edit arsip berdasarkan ID
$route['arsip/delete/(:num)'] = 'arsip/delete/$1';  // Hapus arsip berdasarkan ID
$route['arsip/view/(:num)'] = 'arsip/view/$1';  // Melihat detail arsip

// Backup and Restore Routes
$route['backup'] = 'backup/index';  // Halaman utama backup dan restore
$route['backup/backup'] = 'backup/backup';  // Proses backup data
$route['backup/restore'] = 'backup/restore';  // Proses restore data

// Auth Routes
$route['auth/login'] = 'auth/login';  // Halaman login
$route['auth/do_login'] = 'auth/do_login';  // Proses login
$route['auth/logout'] = 'auth/logout';  // Proses logout

// Admin Kategori Routes
$route['admin/kategori'] = 'admin/kategori';  // Halaman kategori admin
$route['admin/add_category'] = 'admin/add_category';  // Tambah kategori baru
$route['admin/edit_category/(:num)'] = 'admin/edit_category/$1';  // Edit kategori berdasarkan ID
$route['admin/delete_category/(:num)'] = 'admin/delete_category/$1';  // Hapus kategori berdasarkan ID

// Fallback routes
$route['404_override'] = '';  // Halaman error 404
$route['translate_uri_dashes'] = FALSE;  // Tidak mengganti dash pada URI
