<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TukinController;
use App\Http\Controllers\UangMakanController;
use App\Http\Controllers\GajiController;
use App\Http\Controllers\JabatanTukinController;
use App\Http\Controllers\JabatanUnitKerjaController;
use App\Http\Controllers\Pegawai\PegawaiAlamatController;

use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\UserController;
use App\Models\JabatanTukin;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');

Route::resource('tukin', TukinController::class)->only('index', 'store', 'update', 'destroy');
Route::resource('umak', UangMakanController::class)->only('index', 'store', 'update', 'destroy');

Route::prefix('pegawai')->group(function () {
    Route::resource('alamat', PegawaiAlamatController::class)->only('index', 'create', 'store');
    Route::post('alamat/getkota', [PegawaiAlamatController::class, 'getKota'])->name('alamat.getkota');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('gaji', GajiController::class)->only('index', 'create', 'edit', 'store', 'update', 'destroy');
    Route::resource('jabatan-tukin', JabatanTukinController::class)->only('index', 'create', 'edit', 'store', 'update', 'destroy');
    Route::get('/jabatan-tukin/getjabatan/{id}', [JabatanTukinController::class, 'getjabatan']);
    Route::get('/jabatan-tukin/getjenisjabatan', [JabatanTukinController::class, 'getJenisJabatan']);
    Route::get('/jabatan-tukin/gettukin', [JabatanTukinController::class, 'getTukin']);
    Route::get('/jabatan-tukin/getnominal/{id}', [JabatanTukinController::class, 'getNominal']);

    Route::resource('jabatan-unit-kerja', JabatanUnitKerjaController::class)->only('index', 'create', 'edit', 'store', 'update', 'destroy');

    Route::resource('role', RoleController::class);
    Route::resource('permission', PermissionController::class);
    Route::resource('user', UserController::class);
});


require __DIR__ . '/auth.php';
