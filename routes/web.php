<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SessionTimeout;
use App\Http\Controllers\TagihanController;
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
| LOGIN ROUTES
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

/*
|--------------------------------------------------------------------------
| LOGOUT ROUTE
|--------------------------------------------------------------------------
*/
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
    Route::middleware(['role:admin,kepsek'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::resource('siswa', \App\Http\Controllers\SiswaController::class);

            Route::get('/tagihan/create', [TagihanController::class, 'create'])
                ->name('tagihan.create');

            Route::post('/tagihan', [TagihanController::class, 'store'])
                ->name('tagihan.store');

            Route::get('/tagihan', [TagihanController::class, 'index'])
                ->name('tagihan.index');
        });

    /*
    |--------------------------------------------------------------------------
    | GROUP KHUSUS SISWA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:siswa'])
        ->prefix('siswa')
        ->name('siswa.')
        ->group(function () {

            // Dashboard siswa
            Route::get('/dashboard', [SiswaDashboardController::class, 'index'])
                ->name('dashboard');

            // Daftar tagihan
            Route::get('/tagihan', [SiswaTagihanController::class, 'index'])
                ->name('tagihan.index');

            // Detail tagihan
            Route::get('/tagihan/{id}', [SiswaTagihanController::class, 'show'])
                ->name('tagihan.show');

            // Pilih metode pembayaran
            Route::get('/pembayaran/{id}/metode',
                [SiswaTagihanController::class, 'pilihMetode'])
                ->name('pembayaran.metode');

            // Proses pembayaran (simulasi)
            Route::post('/pembayaran/{id}/proses',
                [SiswaTagihanController::class, 'prosesPembayaran'])
                ->name('pembayaran.proses');
        });
});
