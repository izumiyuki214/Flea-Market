<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\Profile;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    // 「購入する」ボタンを押下すると購入が完了する
    public function test_user_can_purchase_item()
    {
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Profile::factory()->create([
            'user_id' => $buyer->id,
            'postal_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'テストビル',
        ]);

        $seller = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $response = $this->actingAs($buyer)->post(route('purchase.store', $item), [
            'payment_method' => 'convenience',
        ]);

        $response->assertRedirect('/mypage?page=buy');

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
            'postal_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'テストビル',
            'payment_method' => 'convenience',
        ]);
    }

    // 購入した商品は商品一覧画面にて「sold」と表示される
    public function test_purchased_item_is_shown_as_sold_in_item_list()
    {
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $seller = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        Purchase::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('items.index'));

        $response->assertOk();
        $response->assertSee('Sold');
    }

    // 「プロフィール/購入した商品一覧」に追加されている
    public function test_purchased_item_is_added_to_profile_buy_page()
    {
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Profile::factory()->create([
            'user_id' => $buyer->id,
            'nickname' => '購入者',
            'profile_image' => 'profiles/test.jpg',
            'postal_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'テストビル',
        ]);

        $seller = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => '購入された商品',
        ]);

        Purchase::factory()->create([
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($buyer)->get('/mypage?page=buy');

        $response->assertOk();
        $response->assertSee('購入された商品');
    }

    // 小計画面で変更が反映される
    public function test_payment_method_select_and_summary_view_exist()
    {
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        Profile::factory()->create([
            'user_id' => $buyer->id,
            'postal_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'テストビル',
        ]);

        $seller = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $response = $this->actingAs($buyer)
            ->get(route('purchase.create', $item));

        $response->assertOk();

        $response->assertSee('支払い方法');
        $response->assertSee('value="convenience"', false);
        $response->assertSee('コンビニ支払い');
        $response->assertSee('value="card"', false);
        $response->assertSee('カード支払い');
        $response->assertSee('id="payment_method_view"', false);
        $response->assertSee('未選択');
    }

    // 送付先住所変更画面にて登録した住所が商品購入画面に反映されている
    public function test_updated_shipping_address_is_reflected_on_purchase_page()
    {
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $seller = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $this->actingAs($buyer)->put(route('purchase.address.update', $item), [
            'postal_code' => '111-1111',
            'address' => '東京都渋谷区',
            'building' => '渋谷ビル',
        ]);

        $response = $this->actingAs($buyer)->get(route('purchase.create', $item));

        $response->assertOk();
        $response->assertSee('111-1111');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('渋谷ビル');
    }

    // 購入した商品に送付先住所が紐づいて登録される
    public function test_updated_shipping_address_is_saved_in_purchase()
    {
        $buyer = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $seller = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $item = Item::factory()->create([
            'user_id' => $seller->id,
        ]);

        $response = $this->actingAs($buyer)
            ->withSession([
                'purchase_address.' . $item->id => [
                    'postal_code' => '111-1111',
                    'address' => '東京都渋谷区',
                    'building' => '渋谷ビル',
                ],
            ])
            ->post(route('purchase.store', $item), [
                'payment_method' => 'card',
            ]);

        $response->assertRedirect('/mypage?page=buy');

        $this->assertDatabaseHas('purchases', [
            'item_id' => $item->id,
            'postal_code' => '111-1111',
            'address' => '東京都渋谷区',
            'building' => '渋谷ビル',
            'payment_method' => 'card',
        ]);
    }
}