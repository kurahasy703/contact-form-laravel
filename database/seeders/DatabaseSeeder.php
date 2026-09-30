<?php

namespace Database\Seeders;

use App\Models\Contact;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. カテゴリーとタグのマスターデータを作成
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
        ]);

        // 2. テスト用管理者ユーザーを作成
        User::create([
            'name' => '管理者ユーザー',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);

        // 3. お問い合わせダミーデータを30件作成し、ランダムにタグを紐付ける
        Contact::factory(30)->create()->each(function ($contact) {
            $tags = Tag::inRandomOrder()->take(rand(1, 3))->pluck('id');
            $contact->tags()->attach($tags);
        });
    }
}
