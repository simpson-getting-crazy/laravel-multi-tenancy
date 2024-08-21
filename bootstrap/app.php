<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Middleware\ForceDevelopmentSetup;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        using: function () {
            $centralDomains = config('tenancy.central_domains');

            foreach ($centralDomains as $domain) {
                Route::middleware('web')
                    ->domain($domain)
                    ->group(base_path('routes/web.php'));
            }

            Route::middleware('web')->group(base_path('routes/tenant.php'));
        },
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->use(
            middleware: [ForceDevelopmentSetup::class]
        );

        $middleware->redirectGuestsTo(
            redirect: fn (Request $request) => route('login.form')
        );

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->render(
        //     using: function (TenantCouldNotBeIdentifiedOnDomainException $e) {
        //         return redirect()->route('home');
        //     }
        // );
    })->create();
