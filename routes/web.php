<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Tenant\DashboardController;

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->as('pages:')->group(static function (): void {
        Route::get('/', [DashboardController::class, 'index'])->name('home')
            ->middleware(['auth']);
        Route::get('/logout', [LoginController::class, 'logout'])->name('logout')
            ->middleware(['auth']);

        Route::prefix('auth')->as('auth:')->group(static function (): void {
            Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register:form');
            Route::post('/register', [RegisterController::class, 'registrationFormAction'])->name('register:action');
        });

        Route::middleware(['guest'])->prefix('auth')->as('auth:')->group(static function (): void {
            Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login:form');
            Route::post('/login', [LoginController::class, 'loginFormAction'])->name('login:action');
        });
    });
}
