<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Like;
use App\Models\Profile;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    // マイリストでいいねした商品だけが表示される
    public function test_mylist_shows_only_liked_items()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $likedItem = Item::factory()->create([
            'name' => 'いいねした商品',
        ]);

        $notLikedItem = Item::factory()->create([
            'name' => 'いいねしていない商品',
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $likedItem->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertOk();
        $response->assertSee('いいねした商品');
        $response->assertDontSee('いいねしていない商品');
    }

    // マイリストで購入済み商品は「Sold」と表示される
    public function test_sold_label_is_displayed_in_mylist()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $seller = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => 'いいね済み商品',
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist');

        $response->assertOk();
        $response->assertSee('いいね済み商品');
        $response->assertSee('Sold');
    }

    // マイリストで未認証の場合は何も表示されない
    public function test_guest_sees_nothing_in_mylist()
    {
        $item = Item::factory()->create([
            'name' => 'いいね済み商品',
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertRedirect('/login');
    }

    // 必要な情報が取得できる（プロフィール画像、ユーザー名、出品した商品一覧、購入した商品一覧）
    public function test_profile_page_displays_required_information()
    {
        $user = User::factory()->create([
            'name' => '元の名前',
            'email_verified_at' => now(),
        ]);

        Profile::factory()->create([
            'user_id' => $user->id,
            'nickname' => '表示名',
            'profile_image' => 'profiles/test.jpg',
            'postal_code' => '123-4567',
            'address' => '東京都港区',
            'building' => '港ビル',
        ]);

        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品した商品',
        ]);

        $buyItem = Item::factory()->create([
            'name' => '購入した商品',
        ]);

        Purchase::factory()->create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
        ]);

        $response = $this->actingAs($user)->get(route('profile.show'));

        $response->assertOk();
        $response->assertSee('表示名');
        $response->assertSee('出品した商品');

        $buyResponse = $this->actingAs($user)->get('/mypage?page=buy');

        $buyResponse->assertOk();
        $buyResponse->assertSee('購入した商品');
    }

    // 変更項目が初期値として過去設定されていること（プロフィール画像、ユーザー名、郵便番号、住所）
    public function test_profile_edit_has_initial_values()
    {
        $user = User::factory()->create([
            'name' => '元の名前',
            'email_verified_at' => now(),
        ]);

        Profile::factory()->create([
            'user_id' => $user->id,
            'nickname' => '表示名',
            'profile_image' => 'profiles/test.jpg',
            'postal_code' => '123-4567',
            'address' => '東京都港区',
            'building' => '港ビル',
        ]);

        $response = $this->actingAs($user)->get(route('profile.edit'));

        $response->assertOk();
        $response->assertSee('表示名');
        $response->assertSee('123-4567');
        $response->assertSee('東京都港区');
    }
}