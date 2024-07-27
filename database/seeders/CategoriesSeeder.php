<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        // Array of categories
        $categories = [
            ['title' => 'Fiction', 'slug' => 'Fiction'],
            ['title' => 'Science Fiction', 'slug' => 'Science Fiction'],
            ['title' => 'Fantasy', 'slug' => 'Fantasy'],
            ['title' => 'Mystery', 'slug' => 'Mystery'],
            ['title' => 'Thriller', 'slug' => 'Thriller'],
            ['title' => 'Biography', 'slug' => 'Biography'],
            ['title' => 'History', 'slug' => 'History'],
            ['title' => 'Philosophy', 'slug' => 'Philosophy'],
            ['title' => 'Poetry', 'slug' => 'Poetry'],
            ['title' => 'Art', 'slug' => 'Art'],
            ['title' => 'Music', 'slug' => 'Music'],


            // Add more categories as needed
        ];

        // Insert categories into the database
        Category::insert($categories);
    }
}
