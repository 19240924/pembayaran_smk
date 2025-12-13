<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SessionTimeout;
use App\Http\Controllers\TagihanController;
use App\Http\Controllers\Siswa\TagihanController as SiswaTagihanController;

/*
|--------------------------------------------------------------------------
| PUBLIC ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (Auth::check()) {
        return redirect('/dashboard');
    }
    return redirect('/login');
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
| LOGOUT
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

    /*
    | Dashboard
    */
    Route::get('/dashboard', function () {
        $user = Auth::user();

        if ($user->role === 'admin' || $user->role === 'kepsek') {
            return view('admin.dashboard');
        }

        return view('siswa.dashboard');
    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN ROUTES
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin,kepsek'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::resource('siswa', \App\Http\Controllers\SiswaController::class);

            // TAGIHAN ADMIN
            Route::get('/tagihan', [TagihanController::class, 'index'])->name('tagihan.index');
            Route::get('/tagihan/create', [TagihanController::class, 'create'])->name('tagihan.create');
            Route::post('/tagihan', [TagihanController::class, 'store'])->name('tagihan.store');
        });

    /*
    |--------------------------------------------------------------------------
    | SISWA ROUTES
    |--------------------------------------------------------------------------
    */
    Route::prefix('siswa')
        ->name('siswa.')
        ->group(function () {

            // Halaman daftar tagihan siswa
            Route::get('/tagihan', [SiswaTagihanController::class, 'index'])
                ->name('tagihan.index');

            // Halaman bayar
            Route::get('/tagihan/{id}/bayar', [SiswaTagihanController::class, 'bayar'])
                ->name('tagihan.bayar');

            // PROSES KONFIRMASI BAYAR 
            Route::post('/tagihan/{id}/bayar', [SiswaTagihanController::class, 'prosesBayar'])
                ->name('tagihan.proses');
        });
});
