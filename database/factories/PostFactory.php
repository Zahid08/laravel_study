<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;

class PostFactory extends Factory
{
    protected $model = Post::class;

    public function definition(): array
    {
        return [
            // user is set via ->for($user, 'author') in the seeder
            'title' => rtrim(ucfirst(fake()->sentence(6)), '.'),
            'body'  => fake()->paragraphs(4, true),
        ];
    }
}
