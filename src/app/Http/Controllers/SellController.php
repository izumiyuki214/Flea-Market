<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SellController extends Controller
{
    public function create()
    {
        return view('sell.create');
    }

    public function store(Request $request)
    {
        //
    }
}
