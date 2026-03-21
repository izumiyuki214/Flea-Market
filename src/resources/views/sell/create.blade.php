@extends('layouts.app')

@section('title', '商品出品')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sell.css') }}">
@endsection

@section('content')
<div class="sell">
    <div class="sell__container">
        <h1 class="page-title">商品の出品</h1>

        <form action="{{ route('sell.store') }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf

            <div class="panel">
                <h2 class="panel__title">商品画像</h2>
                <input type="file" name="image" class="form__input-file">
                @error('image')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="panel">
                <h2 class="panel__title">商品の詳細</h2>

                <div class="form__group">
                    <label class="form__label">カテゴリ</label>
                    <div class="checkbox-list">
                        @foreach($categories as $category)
                            <label class="checkbox-chip">
                                <input type="checkbox" name="categories[]" value="{{ $category->id }}">
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>

                <div class="form__group">
                    <label class="form__label">商品の状態</label>
                    <select name="condition_id" class="form__select">
                        <option value="">選択してください</option>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="panel">
                <h2 class="panel__title">商品名と説明</h2>

                <div class="form__group">
                    <label class="form__label">商品名</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form__input">
                </div>

                <div class="form__group">
                    <label class="form__label">ブランド名</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" class="form__input">
                </div>

                <div class="form__group">
                    <label class="form__label">商品の説明</label>
                    <textarea name="description" rows="5" class="form__textarea">{{ old('description') }}</textarea>
                </div>

                <div class="form__group">
                    <label class="form__label">販売価格</label>
                    <input type="number" name="price" value="{{ old('price') }}" class="form__input">
                </div>
            </div>

            <button type="submit" class="button button--primary button--block">出品する</button>
        </form>
    </div>
</div>
@endsection