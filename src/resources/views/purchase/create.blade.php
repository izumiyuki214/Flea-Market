@extends('layouts.app')

@section('title', '商品購入')

@section('css')
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}">
@endsection

@section('content')
<div class="purchase">
    <form action="{{ route('purchase.store', $item) }}" method="POST" class="purchase__wrap">
        @csrf

        <div class="purchase__main">
            <div class="purchase-item">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="purchase-item__image">
                <div>
                    <h1 class="purchase-item__name">{{ $item->name }}</h1>
                    <p class="purchase-item__price">¥{{ number_format($item->price) }}</p>
                </div>
            </div>

            <div class="panel">
                <h2 class="panel__title">支払い方法</h2>
                <select name="payment_method" class="form__select">
                    <option value="">選択してください</option>
                    <option value="convenience" {{ old('payment_method') === 'convenience' ? 'selected' : '' }}>コンビニ支払い</option>
                    <option value="card" {{ old('payment_method') === 'card' ? 'selected' : '' }}>カード支払い</option>
                </select>
                @error('payment_method')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="panel">
                <div class="panel__header-row">
                    <h2 class="panel__title">配送先</h2>
                    <a href="{{ url('/purchase/address/' . $item->id) }}" class="text-link">変更する</a>
                </div>
                <p>〒{{ $user->postal_code ?? '' }}</p>
                <p>{{ $user->address ?? '' }} {{ $user->building ?? '' }}</p>
            </div>
        </div>

        <aside class="purchase__side">
            <div class="summary">
                <div class="summary__row">
                    <span>商品代金</span>
                    <span>¥{{ number_format($item->price) }}</span>
                </div>
                <button type="submit" class="button button--primary button--block">購入する</button>
            </div>
        </aside>
    </form>
</div>
@endsection