<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'ogut',
            'phone' => 82122533318,
            'email' => 'ogut@mail.com',
            'password' => Hash::make('ogut123')
        ]);
        // User::factory()->create([
        //     'name' => 'Ivan',
        //     'phone' => 81314945133,
        //     'email' => 'ivan@mail.com',
        //     'password' => Hash::make('ivan123')
        // ]);
    }
}
