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

        $user = auth()->user();

        return view('profile.show', compact('user'));
    }

    public function edit()
    {
        $user = auth()->user();

        return view('profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        //
    }
}
