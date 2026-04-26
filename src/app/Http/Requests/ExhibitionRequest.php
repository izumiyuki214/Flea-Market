<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->check();
    }

    public function rules()
    {
        return [
            'image_path' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'categories' => 'required|array|min:1',
            'categories.*' => 'exists:categories,id',
            'condition_id' => 'required|exists:conditions,id',
            'brand' => 'nullable|string|max:255',
            'price' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'image_path.required' => '商品画像を選択してください。',
            'image_path.image' => '画像ファイルを選択してください。',
            'image_path.mimes' => '画像は jpeg, png, jpg 形式でアップロードしてください。',
            'image_path.max' => '画像サイズは2MB以下にしてください。',

            'name.required' => '商品名を入力してください。',
            'name.max' => '商品名は255文字以内で入力してください。',

            'description.required' => '商品の説明を入力してください。',
            'description.max' => '商品の説明は1000文字以内で入力してください。',

            'categories.required' => 'カテゴリを1つ以上選択してください。',
            'categories.array' => 'カテゴリの指定が不正です。',
            'categories.min' => 'カテゴリを1つ以上選択してください。',
            'categories.*.exists' => '選択されたカテゴリが不正です。',

            'condition_id.required' => '商品の状態を選択してください。',
            'condition_id.exists' => '選択された商品の状態が不正です。',

            'brand.max' => 'ブランド名は255文字以内で入力してください。',

            'price.required' => '販売価格を入力してください。',
            'price.integer' => '販売価格は数字で入力してください。',
            'price.min' => '販売価格は1円以上で入力してください。',
        ];
    }
}