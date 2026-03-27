@extends('layouts.app')

@section('title', '住所変更')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('content')
<div class="auth">
    <div class="auth__card auth__card--wide">
        <h1 class="auth__title">住所の変更</h1>

        <form action="{{ route('purchase.address.update', $item->id) }}" method="POST" class="form">
            @csrf
            @method('PUT')

            <div class="form__group">
                <label class="form__label">郵便番号</label>
                <input
                    type="text"
                    name="postal_code"
                    value="{{ old('postal_code') }}"
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
                    value="{{ old('address') }}"
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
                    value="{{ old('building') }}"
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