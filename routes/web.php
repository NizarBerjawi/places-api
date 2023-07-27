<?php

use App\Http\Controllers\TokenController;
use App\Http\Controllers\WebController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

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

Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/introduction', [WebController::class, 'intro'])->name('intro');
Route::get('/documentation', [WebController::class, 'docs'])->name('docs');
Route::get('/flags/{flag}', [WebController::class, 'flags'])->name('flags');
Route::get('/continents', [WebController::class, 'continents'])->name('continents');
Route::get('/countries', [WebController::class, 'countries'])->name('countries');
Route::get('/featureCodes', [WebController::class, 'featureCodes'])->name('featureCodes');
Route::get('/timeZones', [WebController::class, 'timeZones'])->name('timeZones');
Route::get('/languages', [WebController::class, 'languages'])->name('languages');

$twoFactorMiddleware = Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword')
    ? [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'password.confirm']
    : [config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')];

Route::get('user/password', function () {
    return view('admin.password');
})
    ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
    ->name('admin.password');

Route::get('user/authentication', function () {
    return view('admin.authentication');
})
    ->middleware([config('fortify.auth_middleware', 'auth').':'.config('fortify.guard')])
    ->name('admin.authentication');

Route::get('/user/recovery-codes', function () {
    return view('admin.recovery-codes');
})
    ->middleware($twoFactorMiddleware)
    ->name('admin.recovery-codes');

Route::get('user/tokens', [TokenController::class, 'index'])->name('admin.tokens.index');
Route::get('user/tokens/create', [TokenController::class, 'create'])->name('admin.tokens.create');
Route::get('user/tokens/{id}', [TokenController::class, 'show'])->name('admin.tokens.show');
Route::post('user/tokens/create', [TokenController::class, 'store'])->name('admin.tokens.store');
Route::put('user/tokens/{id}', [TokenController::class, 'update'])->name('admin.tokens.update');
Route::delete('user/tokens/{id}', [TokenController::class, 'destroy'])->name('admin.tokens.destroy');

Route::get('user/tokens/{id}/confirm', [TokenController::class, 'confirm'])->name('admin.tokens.confirm');
