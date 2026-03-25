@extends('layouts.app')

@section('title', 'プロフィール編集')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth">
    <div class="auth__card auth__card--wide">
        <h1 class="auth__title">プロフィール設定</h1>

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            @method('PUT')

            <div class="form__group">
                <label class="form__label">プロフィール画像</label>

                <div class="profile-image-area">
                    <div class="profile-icon">
                        @if(optional($user->profile)->profile_image)
                            <img
                                src="{{ asset('storage/' . $user->profile->profile_image) }}"
                                alt="プロフィール画像"
                                class="profile-icon__image"
                            >
                        @else
                            <div class="profile-icon__placeholder"></div>
                        @endif
                    </div>

                    <label class="form__file-label">
                        画像を選択する
                        <input type="file" name="profile_image" class="form__input-file">
                    </label>
                </div>

                @error('profile_image')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">ユーザー名</label>
                <input
                    type="text"
                    name="nickname"
                    value="{{ old('nickname', optional($user->profile)->nickname) }}"
                    class="form__input"
                >
                @error('nickname')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">郵便番号</label>
                <input
                    type="text"
                    name="postal_code"
                    value="{{ old('postal_code', optional($user->profile)->postal_code) }}"
                    class="form__input"
                >
                @error('postal_code')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">住所</label>
                <input
                    type="text"
                    name="address"
                    value="{{ old('address', optional($user->profile)->address) }}"
                    class="form__input"
                >
                @error('address')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form__group">
                <label class="form__label">建物名</label>
                <input
                    type="text"
                    name="building"
                    value="{{ old('building', optional($user->profile)->building) }}"
                    class="form__input"
                >
                @error('building')
                    <p class="form__error">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="button button--primary button--block">
                更新する
            </button>
        </form>
    </div>
</div>
@endsection