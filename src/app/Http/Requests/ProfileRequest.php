<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'nickname' => 'required|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'building' => 'nullable|string|max:255',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'nickname.required' => 'ニックネームを入力してください',
            'nickname.max' => 'ニックネームは255文字以内で入力してください',

            'postal_code.max' => '郵便番号は20文字以内で入力してください',

            'address.max' => '住所は255文字以内で入力してください',

            'building.max' => '建物名は255文字以内で入力してください',

            'profile_image.image' => 'プロフィール画像は画像ファイルを選択してください',
            'profile_image.mimes' => 'プロフィール画像はjpeg・png・jpg形式でアップロードしてください',
            'profile_image.max' => 'プロフィール画像は2MB以内にしてください',
        ];
    }
}