@extends('layouts.app')

@section('title', '商品一覧')

@section('css')
<link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
<div class="page">
    <div class="tabs">
        <a href="{{ url('/') }}" class="tabs__link {{ request('tab') !== 'mylist' ? 'is-active' : '' }}">おすすめ</a>
        <a href="{{ url('/?tab=mylist') }}" class="tabs__link {{ request('tab') === 'mylist' ? 'is-active' : '' }}">マイリスト</a>
    </div>

    <div class="item-grid">
        @forelse($items as $item)
            <a href="{{ url('/item/' . $item->id) }}" class="item-card">
                <div class="item-card__image-wrap">
                    <img src="{{ asset('storage/' . $item->image_path) }}" class="item-card__image">
                    @if($item->purchase)
                        <span class="item-card__sold">Sold</span>
                    @endif
                </div>
                <p class="item-card__name">{{ $item->name }}</p>
            </a>
        @empty
            <p class="empty-message">商品がありません。</p>
        @endforelse
    </div>
</div>
@endsection