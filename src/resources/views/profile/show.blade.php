@extends('layouts.app')

@section('title', 'プロフィール')

@section('css')
<link rel="stylesheet" href="{{ asset('css/profile.css') }}">
<link rel="stylesheet" href="{{ asset('css/items.css') }}">
@endsection

@section('content')
<div class="profile">
    <div class="profile__header">
        <div class="profile__user">
            <img src="{{ optional($user->profile)->profile_image ? asset('storage/' . $user->profile->profile_image) : asset('images/default-user.png') }}" alt="{{ $user->name }}" class="profile__image">
            <h1 class="profile__name">{{ optional($user->profile)->nickname ?? $user->name }}</h1>
        </div>
        <a href="{{ route('profile.edit') }}" class="button button--outline">プロフィールを編集</a>
    </div>

    <div class="tabs">
        <a href="{{ url('/mypage?page=sell') }}" class="tabs__link {{ request('page', 'sell') === 'sell' ? 'is-active' : '' }}">出品した商品</a>
        <a href="{{ url('/mypage?page=buy') }}" class="tabs__link {{ request('page', 'sell') === 'buy' ? 'is-active' : '' }}">購入した商品</a>
    </div>

    <div class="item-grid">
        @forelse($items as $item)
            <a href="{{ url('/item/' . $item->id) }}" class="item-card">
                <div class="item-card__image-wrap">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="item-card__image">
                </div>
                <p class="item-card__name">{{ $item->name }}</p>
            </a>
        @empty
            <p class="empty-message">商品がありません。</p>
        @endforelse
    </div>
</div>
@endsection