<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Condition;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class SellTest extends TestCase
{
    use RefreshDatabase;

    // 商品出品画面にて必要な情報が保存できること
    public function test_user_can_store_item()
    {
        Storage::fake('public');

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $condition = Condition::factory()->create();
        $categories = Category::factory()->count(2)->create();

        $response = $this->actingAs($user)->post(route('sell.store'), [
            'name' => '腕時計',
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
            'condition_id' => $condition->id,
            'categories' => $categories->pluck('id')->toArray(),
            'image_path' => UploadedFile::fake()->image('watch.jpg'),
        ]);

        $response->assertRedirect();

        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
            'condition_id' => $condition->id,
        ]);
    }
}