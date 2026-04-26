<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'item_id' => Item::factory(),
            'postal_code' => '123-4567',
            'address' => '東京都新宿区',
            'building' => 'テストビル',
            'payment_method' => 'convenience',
        ];
    }
}