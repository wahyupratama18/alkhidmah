<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::query()
        ->upsert([
            ['slug' => 'kitab', 'name' => 'Kitab', 'description' => 'Daftar kitab Al Khidmah'],
            ['slug' => 'busana', 'name' => 'Busana', 'description' => 'Daftar busana ala Al Khidmah'],
            ['slug' => 'aksesoris', 'name' => 'Aksesoris', 'description' => 'Aksesoris jama\'ah Al Khidmah'],
        ], 'name');
    }
}
