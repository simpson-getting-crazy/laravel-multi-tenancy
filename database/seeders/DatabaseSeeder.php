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
        $tenant = Tenant::query()->create(
            attributes: [
                'id' => 'daycode',
            ],
        );

        $tenant->domains()->create(
            attributes: [
                'domain' => 'daycode.localhost',
            ],
        );

        Tenant::all()->runForEach(function (Tenant $tenant) {
            User::factory()->create([
                'name' => 'wira',
                'email' => 'wira@mail.com',
            ]);
        });

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@mail.com',
        ]);
    }
}
