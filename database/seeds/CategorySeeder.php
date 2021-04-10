<?php

use App\Category;
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
        $categoryRecords = [
            ['id' => 1, 'parent_id' => 0, 'section_id' => 1, 'category_name' => 'T-Shirts', 'category_image' => '',
                'category_discount' => 0, 'description' => '', 'url' => 't-shirts', 'meta_title' => '', 'meta_description' => '',
                'meta_keywords' => '','status' => 1],
            ['id' => 2, 'parent_id' => 1, 'section_id' => 1, 'category_name' => 'Casual-Shirts', 'category_image' => '',
                'category_discount' => 0, 'description' => '', 'url' => 'casual-shirts', 'meta_title' => '', 'meta_description' => '',
                'meta_keywords' => '','status' => 1],
            ['id' => 3, 'parent_id' => 1, 'section_id' => 1, 'category_name' => 'Sport-Shirts', 'category_image' => '',
                'category_discount' => 0, 'description' => '', 'url' => 'sport-shirts', 'meta_title' => '', 'meta_description' => '',
                'meta_keywords' => '','status' => 1],
        ];
        Category::insert($categoryRecords);
    }
}
