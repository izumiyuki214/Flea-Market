<?php

namespace Tests\Feature;

use App\Models\Profile;
use App\Models\Category;
use App\Models\Condition;
use App\Models\Comment;
use App\Models\Item;
use App\Models\Like;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemTest extends TestCase
{
    use RefreshDatabase;

    // 全商品を取得できる
    public function test_all_items_are_displayed()
    {
        $items = Item::factory()->count(3)->create();

        $response = $this->get(route('items.index'));

        $response->assertOk();

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    // 購入済み商品は「Sold」と表示される
    public function test_sold_label_is_displayed_for_purchased_item()
    {
        $item = Item::factory()->create();

        Purchase::factory()->create([
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('items.index'));

        $response->assertOk();
        $response->assertSee('Sold');
    }

    // 自分が出品した商品は表示されない
    public function test_own_items_are_not_displayed_for_logged_in_user()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $myItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '自分の商品',
        ]);

        $otherItem = Item::factory()->create([
            'name' => '他人の商品',
        ]);

        $response = $this->actingAs($user)->get(route('items.index'));

        $response->assertOk();
        $response->assertDontSee($myItem->name);
        $response->assertSee($otherItem->name);
    }

    // 「商品名」で部分一致検索ができる
    public function test_keyword_search_by_name()
    {
        $target = Item::factory()->create([
            'name' => 'Apple Watch',
        ]);

        $other = Item::factory()->create([
            'name' => 'Nintendo Switch',
        ]);

        $response = $this->get(route('items.index', ['keyword' => 'Apple']));

        $response->assertOk();
        $response->assertSee($target->name);
        $response->assertDontSee($other->name);
    }

    // 検索状態がマイリストでも保持されている
    public function test_search_state_is_kept_in_mylist()
    {
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $matched = Item::factory()->create([
            'name' => 'Apple Watch',
        ]);

        $unmatched = Item::factory()->create([
            'name' => 'Nintendo Switch',
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $matched->id,
        ]);

        Like::factory()->create([
            'user_id' => $user->id,
            'item_id' => $unmatched->id,
        ]);

        $response = $this->actingAs($user)->get('/?tab=mylist&keyword=Apple');

        $response->assertOk();
        $response->assertSee($matched->name);
        $response->assertDontSee($unmatched->name);
    }

    // 必要な情報が表示される
    public function test_item_detail_displays_all_required_information()
    {
        $commentUser = User::factory()->create([
            'name' => 'コメントユーザー',
        ]);

        Profile::factory()->create([
            'user_id' => $commentUser->id,
            'nickname' => 'コメントユーザー',
            'profile_image' => 'profiles/test.jpg',
        ]);

        $category = Category::factory()->create([
            'name' => '家電',
        ]);

        $condition = Condition::factory()->create([
            'name' => '良好',
        ]);

        $item = Item::factory()->create([
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => 'スタイリッシュなデザイン',
            'condition_id' => $condition->id,
            'image_path' => 'items/sample1.jpg',
        ]);

        $item->categories()->attach($category->id);

        Like::factory()->count(2)->create([
            'item_id' => $item->id,
        ]);

        Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $commentUser->id,
            'comment' => '良い商品です',
        ]);

        $response = $this->get(route('items.show', $item));

        $response->assertOk();
        $response->assertSee('腕時計');
        $response->assertSee('Rolax');
        $response->assertSee('15,000');
        $response->assertSee('スタイリッシュなデザイン');
        $response->assertSee('家電');
        $response->assertSee('良好');
        $response->assertSee('2');
        $response->assertSee('1');
        $response->assertSee('コメントユーザー');
        $response->assertSee('良い商品です');

        $response->assertSee('items/sample1.jpg');
    }

    // 複数選択されたカテゴリが表示されているか
    public function test_multiple_categories_are_displayed_on_item_detail()
    {
        $category1 = Category::factory()->create([
            'name' => '家電',
        ]);

        $category2 = Category::factory()->create([
            'name' => 'ファッション',
        ]);

        $item = Item::factory()->create();

        $item->categories()->attach([
            $category1->id,
            $category2->id,
        ]);

        $response = $this->get(route('items.show', $item));

        $response->assertOk();
        $response->assertSee('家電');
        $response->assertSee('ファッション');
    }
}