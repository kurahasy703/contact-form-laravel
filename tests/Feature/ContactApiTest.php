<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Contact;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactApiTest extends TestCase
{
    use RefreshDatabase;

    /**
     * API一覧取得のテスト
     */
    public function test_can_get_contacts_list_via_api(): void
    {
        $category = Category::factory()->create();
        Contact::factory()->count(3)->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/contacts');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'first_name', 'last_name', 'email', 'created_at'],
                ],
            ]);
    }

    /**
     * API経由の新規作成テスト
     */
    public function test_can_create_contact_via_api(): void
    {
        $category = Category::factory()->create();

        $data = [
            'category_id' => $category->id,
            'first_name' => 'テスト',
            'last_name' => '太郎',
            'gender' => 1,
            'email' => 'test@example.com',
            'tel' => '09012345678',
            'address' => '東京都渋谷区',
            'detail' => 'API経由のテスト問い合わせです',
        ];

        $response = $this->postJson('/api/contacts', $data);

        $response->assertStatus(201);
        $this->assertDatabaseHas('contacts', ['email' => 'test@example.com']);
    }
}
