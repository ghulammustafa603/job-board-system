<?php

namespace Database\Seeders;

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
        // User::factory(10)->create();

        \App\Models\User::updateOrCreate(
            ['email' => 'ghulammustafa.bscsf22@iba-suk.edu.pk'],
            [
                'name' => 'Admin User',
                'is_admin' => true,
                'password' => bcrypt('admin12345'),
            ]
        );
    }
}
