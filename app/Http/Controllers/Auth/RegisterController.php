<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Tenant;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle the registration form submission.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function registrationFormAction(Request $request): RedirectResponse
    {
        $tenant = Tenant::query()->create(
            attributes: [
                'id' => Str::snake($request->company_name),
            ],
        );

        $domain = $request->sub_domain.'.'.config('tenancy.central_domains')[0];

        $tenant->domains()->create(
            attributes: [
                'domain' => $domain,
            ],
        );

        Tenant::all()->runForEach(function (Tenant $tenant) use ($request) {
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]);
        });

        return redirect(tenant_route($domain, 'auth:login:form'));
    }
}
