<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        $image = $this->faker->image('public/storage/posts', 850, 350, null, false);

        // Ensure there is at least one admin and one category
        $adminId = User::where('is_admin', true)->inRandomOrder()->first()->id ?? User::factory()->create(['is_admin' => true])->id;
        $categoryId = Category::inRandomOrder()->first()->id ?? Category::factory()->create()->id;

        return [
            'title' => $title,
            'slug' => Str::slug($title),
            'excerpt' => $this->faker->text(100),
            'content' => $this->generateMarkdownContent(),
            'category_id' => $categoryId,
            'user_id' => $adminId,
            'status' => $this->faker->boolean,
            'featured_image' => 'posts/' . $image,
            'published_at' => now()
        ];
    }

    /**
     * Generate Markdown formatted content.
     *
     * @return string
     */
    protected function generateMarkdownContent(): string
    {
        $markdownContent = '';

        for ($i = 0; $i < 3; $i++) {
            $header = $this->faker->sentence;
            $paragraphs = collect($this->faker->paragraphs(mt_rand(3, 5)))
                ->map(fn ($p) => $p . "\n")
                ->implode("\n");

            $markdownContent .= "## $header\n$paragraphs";
        }

        return $markdownContent;
    }
}
