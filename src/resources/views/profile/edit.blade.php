@extends('layouts.app')

@section('title', 'プロフィール編集')

<link rel="stylesheet" href="{{ asset('css/auth.css') }}">

@section('content')
<div class="auth">
    <div class="auth__card auth__card--wide">
        <h1 class="auth__title">プロフィール設定</h1>

        <form action="{{ route('mypage.profile.update') }}" method="POST" enctype="multipart/form-data" class="form">
            @csrf
            @method('PUT')

            <div class="form__group">
                <label class="form__label">プロフィール画像</label>
                <input type="file" name="profile_image" class="form__input-file">
            </div>

            <div class="form__group">
                <label class="form__label">ユーザー名</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form__input">
            </div>

            <div class="form__group">
                <label class="form__label">郵便番号</label>
                <input type="text" name="postal_code" value="{{ old('postal_code', $user->postal_code) }}" class="form__input">
            </div>

            <div class="form__group">
                <label class="form__label">住所</label>
                <input type="text" name="address" value="{{ old('address', $user->address) }}" class="form__input">
            </div>

            <div class="form__group">
                <label class="form__label">建物名</label>
                <input type="text" name="building" value="{{ old('building', $user->building) }}" class="form__input">
            </div>

            <button type="submit" class="button button--primary button--block">更新する</button>
        </form>
    </div>
</div>
@endsection