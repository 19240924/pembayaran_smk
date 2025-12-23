<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SessionTimeout;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaTagihanController;
use App\Http\Controllers\Siswa\SiswaDashboardController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return Auth::check() ? redirect('/dashboard') : redirect('/login');
});

/*
|--------------------------------------------------------------------------
| LOGIN & LOGOUT ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (\Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
})->name('auth.login');

Route::post('/logout', function (\Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
})->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| PROTECTED ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', SessionTimeout::class])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | DASHBOARD (ADMIN & SISWA)
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if (in_array($user->role, ['admin', 'kepsek'])) {
            return view('admin.dashboard');
        }

        return redirect()->route('siswa.dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | GROUP ADMIN & KEPSEK
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin,kepsek'])->prefix('admin')->name('admin.')->group(function () {

        Route::resource('siswa', SiswaController::class);

        Route::get('/tagihan/create', [TagihanController::class, 'create'])->name('tagihan.create');
        Route::post('/tagihan', [TagihanController::class, 'store'])->name('tagihan.store');
        Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');

        Route::get('/tagihan/massal/create', [TagihanController::class, 'createMassal'])->name('tagihan.massal.create');
        Route::post('/tagihan/massal/store', [TagihanController::class, 'storeMassal'])->name('tagihan.massal.store');

        Route::get('/tagihan/{tagihan}/edit', [TagihanController::class, 'edit'])->name('tagihan.edit');
        Route::put('/tagihan/{tagihan}', [TagihanController::class, 'update'])->name('tagihan.update');
        Route::delete('/tagihan/{tagihan}', [TagihanController::class, 'destroy'])->name('tagihan.destroy');

        Route::get('/pembayaran/{id}/cetak', [PembayaranController::class, 'cetak'])->name('pembayaran.cetak');
        Route::resource('pembayaran', PembayaranController::class);

        Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/laporan/cetak', [LaporanController::class, 'cetak'])->name('laporan.cetak');
        Route::get('/laporan/detail/{kelas}/{jurusan}', [LaporanController::class, 'detailKelas'])
            ->name('laporan.detail');
    });

    /*
    |--------------------------------------------------------------------------
    | GROUP KHUSUS SISWA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:siswa'])->prefix('siswa')->name('siswa.')->group(function () {

        // DASHBOARD SISWA
        Route::get('/dashboard', [SiswaDashboardController::class, 'index'])
            ->name('dashboard');

        // TAGIHAN SISWA (BELUM VIEW, BELUM DATABASE)
        Route::get('/tagihan', [SiswaTagihanController::class, 'index'])
            ->name('tagihan.index');

        Route::get('/tagihan/{id}', [SiswaTagihanController::class, 'show'])
            ->name('tagihan.show');
    });

});
