@extends('layouts.app')

@section('title', $item->name)

@section('css')
<link rel="stylesheet" href="{{ asset('css/detail.css') }}">
@endsection

@section('content')
<div class="detail">
    <div class="detail__image-area">
        <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="detail__image">
    </div>

    <div class="detail__content">
        <h1 class="detail__title">{{ $item->name }}</h1>
        <p class="detail__brand">{{ $item->brand }}</p>
        <p class="detail__price">¥{{ number_format($item->price) }}</p>

        <div class="detail__meta">
            <span>♡ {{ $item->likes->count() }}</span>
            <span>💬 {{ $item->comments->count() }}</span>
        </div>

        @auth
            @if(!$item->purchase)
                <a href="{{ url('/purchase/' . $item->id) }}" class="button button--primary button--block">購入手続きへ</a>
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
                            <strong>{{ $comment->user->name }}</strong>
                        </div>
                        <p class="comment-card__body">{{ $comment->comment }}</p>
                    </div>
                @endforeach
            </div>

            @auth
                <form action="{{ route('comments.store', $item) }}" method="POST" class="form mt-16">
                    @csrf
                    <div class="form__group">
                        <label class="form__label">商品へのコメント</label>
                        <textarea name="comment" rows="5" class="form__textarea">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="form__error">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="button button--primary button--block">コメントを送信する</button>
                </form>
            @endauth
        </section>
    </div>
</div>
@endsection