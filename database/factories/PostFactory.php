<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence;
        $slug = Str::slug($title);
        $tags = $this->generateTags();

        return [
            'title' => $title,
            'slug'=> $slug,
            'content' => $this->faker->paragraph($nbSentences = 30),
            'tags' => $tags,
            'user_id' => User::factory(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }

    private function generateTags()
    {
        $tags = [];

        for ($i = 0; $i < 3; $i++) {
            $tags[] = $this->faker->word;
        }

        return $tags;
    }
}
