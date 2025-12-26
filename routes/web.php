<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\SessionTimeout;

use App\Http\Controllers\TagihanController;
use App\Http\Controllers\SiswaTagihanController;
use App\Http\Controllers\Siswa\SiswaDashboardController;
use App\Http\Controllers\SiswaController;

/*
|--------------------------------------------------------------------------
| PUBLIC
|--------------------------------------------------------------------------
*/
Route::get('/', fn() =>
    Auth::check() ? redirect('/dashboard') : redirect('/login')
);

/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/
Route::get('/login', fn() => view('auth.login'))->name('login');

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
| PROTECTED
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', SessionTimeout::class])->group(function () {

    /*
    | DASHBOARD SELECTOR (ROLE)
    */
    Route::get('/dashboard', function () {

        $user = Auth::user();

        if (in_array($user->role, ['admin','kepsek'])) {
            return view('admin.dashboard');
        }

        return redirect()->route('siswa.dashboard');

    })->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | ADMIN & KEPSEK
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:admin,kepsek'])
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            Route::resource('siswa', SiswaController::class);

            Route::get('/tagihan', [TagihanController::class,'index'])
                ->name('tagihan.index');

            Route::get('/tagihan/create', [TagihanController::class,'create'])
                ->name('tagihan.create');

            Route::post('/tagihan', [TagihanController::class,'store'])
                ->name('tagihan.store');

            Route::get('/tagihan/verifikasi', [TagihanController::class,'verifikasi'])
                ->name('tagihan.verifikasi');

            Route::post('/tagihan/{id}/status/{status}',
                [TagihanController::class,'setStatus'])
                ->name('tagihan.setStatus');
        });

    /*
    |--------------------------------------------------------------------------
    | SISWA
    |--------------------------------------------------------------------------
    */
    Route::middleware(['role:siswa'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        // Dashboard siswa
        Route::get('/dashboard', [SiswaDashboardController::class,'index'])
            ->name('dashboard');

        /*
        | TAGIHAN
        | name: siswa.tagihan
        */
        Route::get('/tagihan', [SiswaTagihanController::class,'index'])
            ->name('tagihan');

        Route::get('/tagihan/{id}', [SiswaTagihanController::class,'show'])
            ->name('tagihan.show');

        Route::get('/tagihan/{id}/metode',
            [SiswaTagihanController::class,'pilihMetode'])
            ->name('pembayaran.metode');

        Route::post('/tagihan/{id}/proses',
            [SiswaTagihanController::class,'prosesPembayaran'])
            ->name('pembayaran.proses');

        /*
        | RIWAYAT
        | name: siswa.riwayat
        */
        Route::get('/riwayat',
            [SiswaTagihanController::class,'riwayat'])
            ->name('riwayat');

        /*
        | PROFIL
        | name: siswa.profil
        */
        Route::get('/profil',
            [SiswaTagihanController::class,'profil'])
            ->name('profil');
    });
});
