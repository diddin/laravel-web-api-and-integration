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

        User::factory()->create([
            'name' => 'Muhammad Khusnudin Wahyu Pamungkas',
            'email' => 'diddin.wipe@gmail.com',
            'password' => 'Purworejo'
        ]);

        $this->call([
            PostSeeder::class
        ]);
    }
}
