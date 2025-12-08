<?php

namespace Database\Seeders;

use App\Enums\CategoryType;
use App\Models\General\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        Category::truncate();
        
        $categories = [
            [
                'name' => "South West",
                'category_type' => CategoryType::NIGERIAN,
                'sub_categories' => [
                    [
                        'name' => "Lagos Trips & Tours",
                        'category_type' => CategoryType::NIGERIAN,
                        'description' => "A state in the south western region in Nigeria"
                    ],
                    [
                        'name' => "Ogun Trips & Tours",
                        'category_type' => CategoryType::NIGERIAN,
                        'description' => "A state in the south western region in Nigeria"
                    ],
                    [
                        'name' => "Oyo Trips & Tours",
                        'category_type' => CategoryType::NIGERIAN,
                        'description' => "A state in the south western region in Nigeria"
                    ],
                    [
                        'name' => "Ekiti Trips & Tours",
                        'category_type' => CategoryType::NIGERIAN,
                        'description' => "A state in the south western region in Nigeria"
                    ],
                    [
                        'name' => "Osun Trips & Tours",
                        'category_type' => CategoryType::NIGERIAN,
                        'description' => "A state in the south western region in Nigeria"
                    ],
                    [
                        'name' => "Ondo Trips & Tours",
                        'category_type' => CategoryType::NIGERIAN,
                        'description' => "A state in the south western region in Nigeria"
                    ],
                    [
                        'name' => "Kwara Trips & Tours",
                        'category_type' => CategoryType::NIGERIAN,
                        'description' => "A state in the south western region in Nigeria"
                    ],
                ]
            ],
            [
                'name' => "North East",
                'category_type' => CategoryType::NIGERIAN,
                'sub_categories' => []
            ],
            [
                'name' => "North West",
                'category_type' => CategoryType::NIGERIAN,
                'sub_categories' => []
            ],
            [
                'name' => "North Central",
                'category_type' => CategoryType::NIGERIAN,
                'sub_categories' => []
            ],
            [
                'name' => "South East",
                'category_type' => CategoryType::NIGERIAN,
                'sub_categories' => []
            ],
            [
                'name' => "South South",
                'category_type' => CategoryType::NIGERIAN,
                'sub_categories' => []
            ],
            [
                'name' => "Africa",
                'category_type' => CategoryType::INTERNATIONAL,
                'sub_categories' => [
                    [
                        'name' => "Kenya Trips",
                        'category_type' => CategoryType::INTERNATIONAL,
                        'description' => "A country in East Africa known for safaris and wildlife."
                    ],
                    [
                        'name' => "South Africa Trips",
                        'category_type' => CategoryType::INTERNATIONAL,
                        'description' => "A country at the southern tip of Africa known for Cape Town and Kruger National Park."
                    ],
                    [
                        'name' => "West Africa Packages",
                        'category_type' => CategoryType::INTERNATIONAL,
                        'description' => "Travel packages across countries in West Africa."
                    ],
                    [
                        'name' => "Egypt Trips",
                        'category_type' => CategoryType::INTERNATIONAL,
                        'description' => "A North African country famous for its pyramids and ancient history."
                    ],
                    [
                        'name' => "East Africa Packages",
                        'category_type' => CategoryType::INTERNATIONAL,
                        'description' => "Explore destinations across the East African region."
                    ],
                    [
                        'name' => "North Africa Packages",
                        'category_type' => CategoryType::INTERNATIONAL,
                        'description' => "Discover countries in the northern region of Africa."
                    ],
                    [
                        'name' => "Morocco Trips",
                        'category_type' => CategoryType::INTERNATIONAL,
                        'description' => "A North African country known for its cities, culture, and the Sahara."
                    ],
                ]
            ],
            [
                'name' => "Europe",
                'category_type' => CategoryType::INTERNATIONAL,
                'sub_categories' => []
            ],
            [
                'name' => "Americas",
                'category_type' => CategoryType::INTERNATIONAL,
                'sub_categories' => []
            ],
            [
                'name' => "Asia",
                'category_type' => CategoryType::INTERNATIONAL,
                'sub_categories' => []
            ],
            [
                'name' => "Middle East",
                'category_type' => CategoryType::INTERNATIONAL,
                'sub_categories' => []
            ],
            [
                'name' => "Australia",
                'category_type' => CategoryType::INTERNATIONAL,
                'sub_categories' => []
            ],
        ];

        foreach ($categories as $category) {
            $parent = Category::create([
                'name' => $category['name'],
                'category_type' => $category['category_type'],
                'slug' => Str::slug($category['name'])
            ]);

            if(!empty($category['sub_categories'])){
                foreach ($category['sub_categories'] as $subCategory) {
                    Category::create([
                        'name' => $subCategory['name'],
                        'category_type' => $subCategory['category_type'],
                        'description' => $subCategory['description'],
                        'parent_id' => $parent->id,
                        'top_destination' => random_int(0, 1),
                        'slug' => Str::slug($subCategory['name'])
                    ]);
                }
            }
        }
    }
}
