<?php

use App\Http\Controllers\Dashboard\AccountController;
use App\Http\Controllers\Dashboard\SecurityController;
use App\Http\Controllers\Dashboard\StripeController;
use App\Http\Controllers\Dashboard\TokenController;
use App\Http\Controllers\WebController;
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

Route::get('/', [WebController::class, 'home'])->name('home');
Route::get('/gettingStarted', [WebController::class, 'gettingStarted'])->name('gettingStarted');
Route::get('/documentation', [WebController::class, 'docs'])->name('docs');

Route::get('/flags/{flag}', [WebController::class, 'flags'])->name('flags');
Route::get('/continents', [WebController::class, 'continents'])->name('continents');
Route::get('/countries', [WebController::class, 'countries'])->name('countries');
Route::get('/featureCodes', [WebController::class, 'featureCodes'])->name('featureCodes');
Route::get('/timeZones', [WebController::class, 'timeZones'])->name('timeZones');
Route::get('/languages', [WebController::class, 'languages'])->name('languages');

Route::middleware([
    config('fortify.auth_middleware', 'auth').':'.config('fortify.guard'), 'verified',
])
    ->prefix('user')
    ->group(function () {
        Route::get('/gettingStarted', [WebController::class, 'gettingStarted'])->name('admin.api.gettingStarted');
        Route::get('/documentation', [WebController::class, 'docs'])->name('admin.api.docs');

        Route::get('/confirm-password', [SecurityController::class, 'confirm']);

        Route::get('security', [SecurityController::class, 'index'])->name('admin.security.index');
        Route::get('security/recovery-codes', [SecurityController::class, 'recovery'])
            ->middleware(['password.confirm'])
            ->name('admin.security.recovery-codes');

        Route::prefix('account')
            ->group(function () {
                Route::get('/', [AccountController::class, 'index'])->name('admin.account.index');

                Route::get('{id}/confirm', [AccountController::class, 'confirm'])
                    ->middleware(['password.confirm'])
                    ->name('admin.account.confirm');

                Route::delete('{id}', [AccountController::class, 'destroy'])
                    ->middleware(['password.confirm'])
                    ->name('admin.account.delete');
            });

        Route::prefix('tokens')
            ->group(function () {
                Route::get('/', [TokenController::class, 'index'])->name('admin.tokens.index');
                Route::get('create', [TokenController::class, 'create'])->name('admin.tokens.create');
                Route::get('{uuid}', [TokenController::class, 'show'])->name('admin.tokens.show');
                Route::get('{uuid}/edit', [TokenController::class, 'edit'])->name('admin.tokens.edit');
                Route::post('/', [TokenController::class, 'store'])->name('admin.tokens.store');
                Route::put('{uuid}', [TokenController::class, 'update'])->name('admin.tokens.update');
                Route::delete('{uuid}', [TokenController::class, 'destroy'])->name('admin.tokens.destroy');
                Route::get('{uuid}/confirm', [TokenController::class, 'confirm'])->name('admin.tokens.confirm');
            });

        Route::prefix('stripe')
            ->group(function () {
                Route::get('/checkout', [StripeController::class, 'checkout'])->name('admin.stripe.checkout');
                Route::get('/subscribe', [StripeController::class, 'subscribe'])->name('admin.stripe.subscribe');
                Route::get('/billing-portal', [StripeController::class, 'billing'])->name('admin.stripe.billing');
                Route::get('/plans', [StripeController::class, 'plans'])->name('admin.stripe.plans');
            });
    });
