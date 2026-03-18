<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');

        if ($tab === 'mylist') {
            // マイリスト表示
        } else {
            // トップ商品一覧表示
        }

        return view('items.index');
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }
}
