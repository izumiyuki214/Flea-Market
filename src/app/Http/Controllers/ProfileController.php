<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function show(Request $request)
    {
        $page = $request->query('page');

        if ($page === 'buy') {
            // 購入した商品一覧
        } elseif ($page === 'sell') {
            // 出品した商品一覧
        } else {
            // デフォルト表示
        }

        return view('profile.show');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        //
    }
}
