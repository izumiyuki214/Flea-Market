<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    // ログイン済みのユーザーはコメントを送信できる
    public function test_logged_in_user_can_post_comment()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $response = $this->actingAs($user)->post(route('comments.store', $item), [
            'comment' => 'テストコメントです',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメントです',
        ]);
    }

    // ログイン前のユーザーはコメントを送信できない
    public function test_guest_cannot_post_comment()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('comments.store', $item), [
            'comment' => 'テストコメントです',
        ]);

        $response->assertRedirect('/login');
    }

    // コメントが入力されていない場合、バリデーションメッセージが表示される
    public function test_comment_required_validation()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $response = $this->from(route('items.show', $item))
            ->actingAs($user)
            ->post(route('comments.store', $item), [
                'comment' => '',
            ]);

        $response->assertRedirect(route('items.show', $item));
        $response->assertSessionHasErrors(['comment']);
    }

    // コメントが255字以上の場合、バリデーションメッセージが表示される
    public function test_comment_max_255_validation()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create();

        $response = $this->from(route('items.show', $item))
            ->actingAs($user)
            ->post(route('comments.store', $item), [
                'comment' => str_repeat('あ', 256),
            ]);

        $response->assertRedirect(route('items.show', $item));
        $response->assertSessionHasErrors(['comment']);
    }
}