<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ForceDevelopmentSetup
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->getHost() === '127.0.0.1' && env('APP_FORCE_LOCALHOST')) {
            $newUrl = str_replace('127.0.0.1', 'localhost', $request->fullUrl());

            return redirect()->to(
                path: $newUrl,
                status: !$request->isMethod('get') ? 307 : 302
            );
        }

        return $next($request);
    }
}
