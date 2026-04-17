<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Artisan::call('make:filament-user', [
            '--name'     => 'Admin',
            '--email'    => 'admin@admin.com',
            '--password' => 'password',
        ]);

        $this->call(LmsSeeder::class);
    }
}
