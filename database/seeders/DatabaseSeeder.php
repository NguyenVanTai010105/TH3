<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Products;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Gọi các Seeder con ở đây
        // $this->call([
        //     PostSeeder::class, // ← Đăng ký PostSeeder
        // ]);
        Product::factory(1000)->create();
        
    }
}
