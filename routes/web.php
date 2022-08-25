<?php

use App\Http\Controllers\EmployeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ReligionController;
use App\Models\Employe;
use Illuminate\Support\Facades\Route;

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
    $jumlahpegawai = Employe::count();
    $jumlahpegawaicowo = Employe::where('jeniskelamin', 'cowo')->count();
    $jumlahpegawaicewe = Employe::where('jeniskelamin', 'cewe')->count();
    return view('welcome', compact('jumlahpegawai', 'jumlahpegawaicowo', 'jumlahpegawaicewe'));
})->middleware('auth');

Route::group(['middleware' => ['auth', 'hakakses:admin']], function () {

});

Route::get('/pegawai', [EmployeController::class, 'index'])->name('pegawai')->middleware('auth');

Route::get('/tambahpegawai', [EmployeController::class, 'tambahpegawai'])->name('tambahpegawai');
Route::post('/insertdata', [EmployeController::class, 'insertdata'])->name('insertdata');

Route::get('/tampilkandata/{id}', [EmployeController::class, 'tampilkandata'])->name('tampilkandata');
Route::post('/updatedata/{id}', [EmployeController::class, 'updatedata'])->name('updatedata');


Route::get('/delete/{id}', [EmployeController::class, 'delete'])->name('delete');

//export pdf
Route::get('/exportpdf', [EmployeController::class, 'exportpdf'])->name('exportpdf');
//export excel
Route::get('/exportexcel', [EmployeController::class, 'exportexcel'])->name('exportexcel');
//import excel
Route::post('/importexcel', [EmployeController::class, 'importexcel'])->name('importexcel');
//login
Route::get('/login', [LoginController::class, 'login'])->name('login');
Route::post('/loginproses', [LoginController::class, 'loginproses'])->name('loginproses');
//register
Route::get('/register', [LoginController::class, 'register'])->name('register');
Route::post('/registeruser', [LoginController::class, 'registeruser'])->name('registeruser');
//logout
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

//religion
Route::get('/datareligion', [ReligionController::class, 'index'])->name('datareligion')->middleware('auth');
//view
Route::get('/tambahagama', [ReligionController::class, 'create'])->name('tambahagama');
//insert
Route::post('/insertdatareligion', [ReligionController::class, 'store'])->name('insertdatareligion');
