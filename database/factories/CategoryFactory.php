<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            'content' => fake()->randomElement(['商品に関するお問い合わせ', 'サービスに関するお問い合わせ', 'その他']),
        ];
    }
}
