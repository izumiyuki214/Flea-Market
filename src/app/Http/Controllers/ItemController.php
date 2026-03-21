<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $tab = $request->query('tab');

        if ($tab === 'mylist') {
            if (!Auth::check()) {
                return redirect('/login');
            }

            $items = Auth::user()
                ->likes()
                ->with('condition', 'user')
                ->latest()
                ->get();
        } else {
            $items = Item::with('condition', 'user')
                ->latest()
                ->get();
        }

        return view('items.index', compact('items', 'tab'));
    }

    public function show(Item $item)
    {
        return view('items.show', compact('item'));
    }
}
