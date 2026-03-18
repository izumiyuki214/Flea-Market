<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function create(Item $item)
    {
        return view('purchase.create', compact('item'));
    }

    public function store(Request $request, Item $item)
    {
        //
    }

    public function editAddress(Item $item)
    {
        return view('purchase.address', compact('item'));
    }

    public function updateAddress(Request $request, Item $item)
    {
        //
    }
}