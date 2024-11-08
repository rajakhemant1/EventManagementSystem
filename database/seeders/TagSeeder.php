<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tag;

class TagSeeder extends Seeder
{
    public function run()
    {
        $tags = [
            'Technology',
            'Health',
            'Business',
            'Education',
            'Science',
            'Art',
            'Entertainment',
            'Environment',
            'Sports',
            'Finance'
        ];

        foreach ($tags as $tag) {
            Tag::create(['name' => $tag]);
        }
    }
}
