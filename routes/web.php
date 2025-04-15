<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Route::resource('pelanggans', PelangganController::class);

Route::get('/penjualans', 'PenjualanController@index')->name('penjualans.index');
Route::get('/penjualans/create', 'PenjualanController@create')->name('penjualans.create');
Route::post('/penjualans', 'PenjualanController@store')->name('penjualans.store');
Route::get('/penjualans/{id}', 'PenjualanController@show')->name('penjualans.show');
Route::delete('/penjualans/{id}', 'PenjualanController@destroy')->name('penjualans.destroy');
Route::get('/penjualans/print/{id}', 'PenjualanController@printStruk')->name('penjualans.print');

// ✅ Route edit & update transaksi penjualan
Route::get('/penjualans/{id}/edit', 'PenjualanController@edit')->name('penjualans.edit');
Route::put('/penjualans/{id}', 'PenjualanController@update')->name('penjualans.update');



Route::resource('produks', ProdukController::class);

Route::resource('users', UserController::class);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/dashboard', 'DashboardController@index')->name('dashboard');

Route::get('/search', 'SearchController@search')->name('search');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');


Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');

Route::post('register', 'Auth\RegisterController@register');

// Routes untuk halaman akun
// routes/web.php

Route::get('/account', 'UserController@show')->name('account.show');

// Menampilkan form untuk mengedit akun pengguna
Route::get('/account/edit', 'UserController@edit')->name('account.edit');

// Menangani permintaan untuk memperbarui akun pengguna
Route::post('/account/update', 'UserController@update')->name('account.update');

Route::get('/login', 'LoginController@showLoginForm')->name('login');
Route::post('/login', 'LoginController@login');

Route::get('/', function () {
    return view('welcome');
});

Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');


Route::get('/send-test-email', 'MailController@sendTestEmail');

Route::get('/laporans', 'PenjualanController@laporan')->name('laporans.index');

Route::get('/laporans/cetak', 'PenjualanController@cetakLaporan')->name('laporans.cetak');