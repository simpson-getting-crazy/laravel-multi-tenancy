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
        $user = User::query()->create(
            attributes: [
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'email_verified_at' => now(),
                'remember_token' => Str::random(10),
            ]
        );

        $tenant = Tenant::query()->create(
            attributes: [
                'name' => Str::snake($request->company_name),
            ]
        );

        $tenant->domains()->create(
            attributes: [
                'domain' => $request->sub_domain.'.'.config('tenancy.central_domains')[0],
            ]
        );

        $user->tenants()->attach($tenant->id);

        return redirect()
            ->route('login.form')
            ->with('toastSuccess', 'Registraion Successfully');
    }
}
