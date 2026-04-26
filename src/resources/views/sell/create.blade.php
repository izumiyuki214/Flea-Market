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
                <label class="form__label">商品画像</label>
                <div class="panel_box">
                    <label class="form__file-button">
                        画像を選択する        
                        <input type="file" name="image_path" class="form__input-file">
                    </label>
                </div>
                @error('image_path')
                    <p class="form__error">{{ $message }}</p>
                @enderror


            </div>

            <div class="panel">
                <h2 class="panel__title">商品の詳細</h2>

                <div class="form__group">
                    <label class="form__label">カテゴリー</label>
                    <div class="checkbox-list">
                        @foreach($categories as $category)
                            <label class="checkbox-chip">
                                <input class="checkbox-input" 
                                type="checkbox" name="categories[]" value="{{ $category->id }}" {{ in_array($category->id, old('categories', [])) ? 'checked' : '' }}>
                                <span>{{ $category->name }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('categories')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form__group">
                    <label class="form__label">商品の状態</label>
                    <select name="condition_id" class="form__select">
                        <option value="" disabled selected>選択してください</option>
                        @foreach($conditions as $condition)
                            <option value="{{ $condition->id }}" {{ old('condition_id') == $condition->id ? 'selected' : '' }}>
                                {{ $condition->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('condition_id')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="panel">
                <h2 class="panel__title">商品名と説明</h2>

                <div class="form__group">
                    <label class="form__label">商品名</label>
                    <input type="text" name="name" value="{{ old('name') }}" class="form__input">
                    @error('name')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form__group">
                    <label class="form__label">ブランド名</label>
                    <input type="text" name="brand" value="{{ old('brand') }}" class="form__input">
                </div>

                <div class="form__group">
                    <label class="form__label">商品の説明</label>
                    <textarea name="description" rows="5" class="form__textarea">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="form__error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form__group price-from">
                    <label class="form__label">販売価格</label>
                    <input type="text" name="price" value="{{ old('price') }}" class="form__input">
                    @error('price')
                        <p class="form__error">{{ $message }}</p>
                    @enderror                    
                </div>
            </div>

            <button type="submit" class="button--orange">出品する</button>
        </form>
    </div>
</div>
@endsection