<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(4);
        $titleEn = fake()->optional(0.7)->sentence(4);

        return [
            'author_id' => User::factory(),
            'title' => $title,
            'title_en' => $titleEn,
            'slug' => Str::slug($title),
            'excerpt' => fake()->paragraph(2),
            'excerpt_en' => fake()->optional(0.7)->paragraph(2),
            'content' => fake()->paragraphs(5, true),
            'content_en' => fake()->optional(0.6)->paragraphs(5, true),
            'featured_image' => null,
            'link' => fake()->optional(0.4)->url(),
            'status' => fake()->randomElement(['draft', 'published', 'archived']),
            'published_at' => now(),
        ];
    }
}
