<?php

namespace Database\Seeders;

use App\Models\Tenant;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $user = \App\Models\User::factory()->create(
            attributes: [
                'name' => 'Wirandra Alaya',
                'email' => 'daycodestudio@gmail.com',
            ]
        );

        $tenant = Tenant::query()->create(
            attributes: [
                'name' => 'daycode',
            ]
        );

        $tenant->domains()->create(
            attributes: [
                'domain' => 'daycode.localhost'
            ]
        );

        $user->tenants()->attach($tenant->id);
    }
}
