<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Travel', 'slug' => 'travel', 'description' => 'Travel tips and destination guides.'],
            ['name' => 'Technology', 'slug' => 'technology', 'description' => 'Latest tech trends and news.'],
        ];

        foreach ($categories as $category) {
            if (!Category::where('slug', $category['slug'])->exists()) {
                Category::create($category);
            }
        }
    }
}
