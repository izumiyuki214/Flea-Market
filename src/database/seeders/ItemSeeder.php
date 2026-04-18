<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\User;

class ItemSeeder extends Seeder
{
    public function run()
    {
        $item = Item::create([
            'name' => '腕時計',
            'brand' => 'Rolax',
            'price' => 15000,
            'description' => 'スタイリッシュなデザインのメンズ腕時計',
            'condition_id' => 1,
            'user_id' => User::first()->id,
            'image_path' => 'items/sample0.jpg'
        ]);
        $item->categories()->attach([1,5,11,12]);

        $item = Item::create([
            'name' => 'HDD',
            'brand' => '西芝',
            'price' => 5000,
            'description' => '高速で信頼性の高いハードディスク',
            'condition_id' => 2,
            'user_id' => User::first()->id,
            'image_path' => 'items/sample1.jpg'
        ]);
        $item->categories()->attach([2]);

        $item = Item::create([
            'name' => '玉ねぎ３束',
            'brand' => 'なし',
            'price' => 300,
            'description' => '新鮮な玉ねぎ３束のセット',
            'condition_id' => 3,
            'user_id' => User::first()->id,
            'image_path' => 'items/sample2.jpg'
        ]);
        $item->categories()->attach([10]);

        $item = Item::create([
            'name' => '革靴',
            'brand' => '',
            'price' => 4000,
            'description' => 'クラシックなデザインの革靴',
            'condition_id' => 4,
            'user_id' => User::first()->id,
            'image_path' => 'items/sample3.jpg'
        ]);
        $item->categories()->attach([1,5,11]);

        $item = Item::create([
            'name' => 'ノートPC',
            'brand' => '',
            'price' => 45000,
            'description' => '高性能なノートパソコン',
            'condition_id' => 1,
            'user_id' => User::first()->id,
            'image_path' => 'items/sample4.jpg'
        ]);
        $item->categories()->attach([2,3]);

        $item = Item::create([
            'name' => 'マイク',
            'brand' => 'なし',
            'price' => 8000,
            'description' => '高音質のレコーディング用マイク',
            'condition_id' => 2,
            'user_id' => User::first()->id,
            'image_path' => 'items/sample5.jpg'
        ]);
        $item->categories()->attach([2,3]);

        $item = Item::create([
            'name' => 'ショルダーバッグ',
            'brand' => '',
            'price' => 3500,
            'description' => 'おしゃれなショルダーバッグ',
            'condition_id' => 3,
            'user_id' => User::first()->id,
            'image_path' => 'items/sample6.jpg'
        ]);
        $item->categories()->attach([1,4,11]);

        $item = Item::create([
            'name' => 'タンブラー',
            'brand' => 'なし',
            'price' => 500,
            'description' => '使いやすいタンブラー',
            'condition_id' => 4,
            'user_id' => User::first()->id,
            'image_path' => 'items/sample7.jpg'
        ]);
        $item->categories()->attach([3,10]);

        $item = Item::create([
            'name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'price' => 4000,
            'description' => '手動のコーヒーミル',
            'condition_id' => 1,
            'user_id' => User::first()->id,
            'image_path' => 'items/sample8.jpg'
        ]);
        $item->categories()->attach([3,10]);

        $item = Item::create([
            'name' => 'メイクセット',
            'brand' => '',
            'price' => 2500,
            'description' => '便利なメイクアップセット',
            'condition_id' => 2,
            'user_id' => User::first()->id,
            'image_path' => 'items/sample9.jpg'
        ]);
        $item->categories()->attach([1,4,6]);

    }
}