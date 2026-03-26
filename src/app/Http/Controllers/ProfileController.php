<?php

namespace App\Http\Controllers;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Item;

class ProfileController extends Controller
{

    public function show(Request $request)
    {
        $user = Auth::user()->load('profile');

        $page = $request->query('page', 'sell');

        if ($page === 'buy') {
            $items = Item::whereHas('purchase', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->latest()->get();
        } else {
            $items = $user->items()->latest()->get();
        }

        return view('profile.show', compact('user', 'items', 'page'));
    }

    public function edit()
    {
        $user = Auth::user()->load('profile');

        return view('profile.edit', compact('user'));
    }

    public function update(ProfileRequest $request)
    {
        $user = Auth::user();

        $profile = $user->profile()->firstOrNew([
            'user_id' => $user->id,
        ]);

        $data = [
            'nickname'    => $request->nickname,
            'postal_code' => $request->postal_code,
            'address'     => $request->address,
            'building'    => $request->building,
        ];

        if ($request->hasFile('profile_image')) {
            $path = $request->file('profile_image')->store('profiles', 'public');
            $data['profile_image'] = $path;
        }

        $profile->fill($data);
        $profile->save();

        return redirect()->route('profile.show');
    }
}