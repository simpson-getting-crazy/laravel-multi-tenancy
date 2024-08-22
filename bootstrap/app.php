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
        web: __DIR__ . '/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {

        $middleware->redirectGuestsTo(
            redirect: fn (Request $request) => route('pages:auth:register:form')
        );

        $middleware->group('universal', []);

    })
    ->withExceptions(function (Exceptions $exceptions) {
        // $exceptions->render(
        //     using: function (TenantCouldNotBeIdentifiedOnDomainException $e) {
        //         return redirect()->route('home');
        //     }
        // );
    })->create();
