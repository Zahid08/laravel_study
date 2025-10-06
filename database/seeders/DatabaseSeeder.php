<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use App\Models\Post;
use App\Models\Role;
use App\Models\Tag;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        DB::transaction(function () {
            // 1) Core lookup tables
            $roleNames = ['admin', 'editor', 'member'];
            $tagNames  = ['laravel', 'php', 'tips', 'eloquent', 'testing', 'beginners', 'advanced'];

            $roles = collect($roleNames)->map(fn ($name) =>
            Role::firstOrCreate(['name' => $name])
            );

            $tags = collect($tagNames)->map(fn ($name) =>
            Tag::firstOrCreate(['name' => $name])
            );

            // 2) Users (+ profile, + single image)
            $users = User::factory()->count(10)->create();
            $users->each(function (User $user) {
                // profile (1–1)
                $user->profile()->create([
                    'bio'     => fake()->realText(80)
                ]);

                // user image (poly morphOne)
                $user->image()->updateOrCreate([], [
                    'path' => "/uploads/users/{$user->id}.png",
                ]);
            });

            // 3) Attach roles to users (M–M with pivot data)
            $users->each(function (User $user) use ($roles) {
                $attach = $roles->random(rand(1, 3))
                    ->pluck('id')
                    ->mapWithKeys(fn ($id) => [$id => ['assigned_at' => now()]])
                    ->all();

                $user->roles()->syncWithoutDetaching($attach);
            });

            // 4) Posts (+ images, + comments, + tags)
            // Each user writes 3–6 posts
            $users->each(function (User $author) use ($users, $tags) {
                Post::factory(rand(3, 6))
                    ->for($author, 'author') // belongsTo alias set in your Post model
                    ->create()
                    ->each(function (Post $post) use ($author, $users, $tags) {
                        // Post images (poly morphMany)
                        $imageCount = rand(1, 3);
                        for ($i = 1; $i <= $imageCount; $i++) {
                            $post->images()->create([
                                'path' => "/uploads/posts/{$post->id}-{$i}.png",
                            ]);
                        }

                        // Comments (poly morphMany)
                        $commenters = $users->where('id', '!=', $author->id)->shuffle()->take(rand(2, 6));
                        foreach ($commenters as $commenter) {
                            $post->comments()->create([
                                'user_id' => $commenter->id,
                                'body'    => fake()->sentences(rand(1, 3), true),
                            ]);
                        }

                        // Tags (poly M–M)
                        $chosen = $tags->shuffle()->take(rand(1, 4))->pluck('id');
                        $post->tags()->syncWithoutDetaching($chosen);
                    });
            });
        });

        $this->command?->info('✅ Seed complete: users/profiles/posts/roles/pivot/images/comments/tags/taggables populated.');
    }
}
