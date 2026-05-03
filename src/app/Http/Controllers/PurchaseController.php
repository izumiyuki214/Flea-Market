<?php

namespace App\Http\Controllers;

use App\Http\Requests\PurchaseAddressRequest;
use App\Models\Item;
use App\Models\Purchase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\Checkout\Session;

class PurchaseController extends Controller
{
    /**
     * 購入画面表示
     */
    public function create($item_id)
    {
        $user = Auth::user()->load('profile');
        $item = Item::with('purchase')->findOrFail($item_id);

        if ($item->user_id === $user->id) {
            return redirect('/')->with('error', '自分が出品した商品は購入できません。');
        }

        if ($item->purchase) {
            return redirect('/');
        }

        $sessionAddress = session('purchase_address.' . $item->id);

        if ($sessionAddress !== null) {
            $shippingAddress = [
                'postal_code' => $sessionAddress['postal_code'],
                'address' => $sessionAddress['address'],
                'building' => $sessionAddress['building'],
            ];
        } else {
            $shippingAddress = [
                'postal_code' => optional($user->profile)->postal_code,
                'address' => optional($user->profile)->address,
                'building' => optional($user->profile)->building,
            ];
        }

        return view('purchase.create', compact('item', 'shippingAddress'));
    }

    /**
     * 住所変更画面表示
     */
    public function editAddress($item_id)
    {
        $item = Item::findOrFail($item_id);

        return view('purchase.address', compact('item'));
    }

    /**
     * 住所変更更新
     */
    public function updateAddress(PurchaseAddressRequest $request, $item_id)
    {
        Item::findOrFail($item_id);

        session([
            'purchase_address.' . $item_id => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building' => $request->building,
            ]
        ]);

        return redirect()->route('purchase.create', $item_id);
    }

    /**
     * 購入処理
     */
    public function store(Request $request, $item_id)
    {
        $user = Auth::user()->load('profile');
        $item = Item::with('purchase')->findOrFail($item_id);

        if ($item->user_id === $user->id) {
            return redirect('/');
        }

        if ($item->purchase) {
            return redirect('/');
        }

        if ($request->payment_method === 'card') {
            Stripe::setApiKey(config('services.stripe.secret'));

            $session = Session::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'jpy',
                        'product_data' => [
                            'name' => $item->name,
                        ],
                        'unit_amount' => $item->price,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => url('/purchase/success/' . $item->id),
                'cancel_url' => url('/purchase/' . $item->id),
            ]);

            return redirect($session->url);
        }

        $sessionAddress = session('purchase_address.' . $item->id);

        if ($sessionAddress !== null) {
            $postalCode = $sessionAddress['postal_code'];
            $address = $sessionAddress['address'];
            $building = $sessionAddress['building'];
        } else {
            $postalCode = optional($user->profile)->postal_code;
            $address = optional($user->profile)->address;
            $building = optional($user->profile)->building;
        }

        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'postal_code' => $postalCode,
            'address' => $address,
            'building' => $building,
            'payment_method' => $request->payment_method,
        ]);

        session()->forget('purchase_address.' . $item->id);

        return redirect('/mypage?page=buy');
    }
}