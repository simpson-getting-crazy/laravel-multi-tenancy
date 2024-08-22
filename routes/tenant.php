<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Tenant\DashboardController;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;

Route::middleware([
    'web',
    InitializeTenancyByDomain::class,
    PreventAccessFromCentralDomains::class,
])->group(function () {

    Route::middleware(['guest'])->prefix('auth')->as('auth:')->group(static function (): void {
        Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login:form');
        Route::post('/login', [LoginController::class, 'loginFormAction'])->name('login:action');
    });

    Route::middleware(['auth'])->group(static function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('home');

        Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
    });;

});

