@extends('layouts.app')

@section('title', $item->name)

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail">
    <div class="detail__image-area">
        <img src="{{ asset($item->image_path) }}" alt="{{ $item->name }}" class="detail__image">
    </div>

    <div class="detail__content">
        <h1 class="detail__title">{{ $item->name }}</h1>
        <p class="detail__brand">{{ $item->brand }}</p>
        <p class="detail__price">¥{{ number_format($item->price) }}(税込)</p>

        <div class="detail__meta">
            <div class="detail__meta-item">
            @if(Auth::check())
                @if ($item->isLikedBy(auth()->user()))
                    <form action="{{ route('likes.destroy', $item) }}" method="POST" class="like-form">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="like-button">
                            <img src="{{ asset('img/like-logo--pink.png') }}" alt="いいね解除" class="detail__meta--icon">
                        </button>
                    </form>
                @else
                    <form action="{{ route('likes.store', $item) }}" method="POST" class="like-form">
                        @csrf
                        <button type="submit" class="like-button">
                            <img src="{{ asset('img/like-logo--default.png') }}" alt="いいね" class="detail__meta--icon">
                        </button>
                    </form>
                @endif
            @else
                <a href="/login">
                    <img src="{{ asset('img/like-logo--default.png') }}" class="detail__meta--icon">
                </a>
            @endif
            <p class="detail__meta--count">{{ $item->likes()->count() }}</p>

            </div>
            <div class="detail__meta-item">
                <img src="{{ asset('img/comment-logo.png') }}" class="detail__meta--icon">
                <p class="detail__meta--count">{{ $item->comments->count() }}</p>
            </div>
        </div>

        @auth
            @if(!$item->purchase)
                <a href="{{ url('/purchase/' . $item->id) }}" class="button--orange">購入手続きへ</a>
            @endif
        @endauth

        <section class="detail__section">
            <h2 class="detail__heading">商品説明</h2>
            <p class="detail__text">{{ $item->description }}</p>
        </section>

        <section class="detail__section">
            <h2 class="detail__heading">商品の情報</h2>
            <p class="detail__text">カテゴリ:
                @foreach($item->categories as $category)
                    <span class="tag">{{ $category->name }}</span>
                @endforeach
            </p>
            <p class="detail__text">商品の状態: {{ $item->condition->name }}</p>
        </section>

        <section class="detail__section">
            <h2 class="detail__heading">コメント({{ $item->comments->count() }})</h2>

            <div class="comment-list">
                @foreach($item->comments as $comment)
                    <div class="comment-card">
                        <div class="comment-card__header">
                            <img src="{{asset('storage/' . $comment->user->profile->profile_image)}}" class="comment__image">
                            <strong  class="comment__name">{{ optional($comment->user->profile)->nickname }}</strong>
                        </div>
                        <p class="comment-card__body">{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </div>

            @auth
                <form action="{{ route('comments.store', $item) }}" method="POST" class="form mt-16">
                    @csrf
                    <div class="form__group">
                        <p class="form__label">商品へのコメント</p>
                        <textarea name="comment" rows="5" class="form__textarea">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="button--orange">コメントを送信する</button>
                </form>
            @endauth
        </section>
    </div>
</div>
@endsection