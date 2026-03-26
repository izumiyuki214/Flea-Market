<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Item $item)
    {
        $item->likes()->firstOrCreate([
            'user_id' => auth()->id(),
        ]);

        return back();
    }

    public function destroy(Item $item)
    {
        $item->likes()->where('user_id', auth()->id())->delete();

        return back();
    }
}