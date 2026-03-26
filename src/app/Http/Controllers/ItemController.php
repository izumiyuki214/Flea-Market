<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');
        $keyword = $request->query('keyword');

        if ($tab === 'mylist') {
            if (!Auth::check()) {
                return redirect('/login');
            }

            $items = Auth::user()
                ->likedItems()
                ->keywordSearch($keyword)
                ->latest()
                ->get();
        } else {
            $items = Item::query()
                ->keywordSearch($keyword)
                ->latest()
                ->get();
        }

        return view('items.index', compact(
            'items',
            'tab',
            'keyword'
        ));
    }

    public function show(Item $item)
    {
        $item->load([
            'user',
            'comments.user',
        ]);

        return view('items.show', compact('item'));
    }
}
