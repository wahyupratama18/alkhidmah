<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::query()->create([
            'name' => 'Administrator',
            'email' => 'admin@alkhidmahmalangkota.id',
            'password' => Hash::make('@Khidmah2005')
        ]);
        // \App\Models\User::factory(10)->create();
    }
}
