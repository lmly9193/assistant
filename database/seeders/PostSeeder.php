<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\PostTag;
use App\Models\Post;

class PostSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Post::factory()
            ->test()
            ->uncategorized()
            ->has(PostTag::factory()->count(3), 'tags')
            ->count(10)
            ->create();
    }
}
