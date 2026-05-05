<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::create(['name' => 'Elektronika', 'slug' => Str::slug('Elektronika')]);
        Category::create(['name' => 'Meubels', 'slug' => Str::slug('Meubels')]);
        Category::create(['name' => 'Kleding', 'slug' => Str::slug('Kleding')]);
        Category::create(['name' => 'Boeken', 'slug' => Str::slug('Boeken')]);
        Category::create(['name' => 'Speelgoed', 'slug' => Str::slug('Speelgoed')]);
        Category::create(['name' => 'Huishoudartikelen', 'slug' => Str::slug('Huishoudartikelen')]);
        Category::create(['name' => 'Sieraden', 'slug' => Str::slug('Sieraden')]);
        Category::create(['name' => 'Verzamelobjecten', 'slug' => Str::slug('Verzamelobjecten')]);
    }
}
