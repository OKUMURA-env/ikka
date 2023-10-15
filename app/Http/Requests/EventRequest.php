<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'item' => 'required',
            'driver_id' => 'string|max:1',
            'schedule_category_id' => 'string|max:1',
            'pickup_location' => 'required',
            'dropoff_location' => 'required',
        ];
    }

    /**
     * カスタムメッセージを返す
     *
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => 'タイトルが未入力です。',
            'item.required' => '品目が未入力です。',
            'driver_id' => 'ドライバーを選択してください。',
            'schedule_category_id' => 'カテゴリーを選択してください。',
            'pickup_location.required' => '積み込み先が未入力です。',
            'dropoff_location.required' => '荷下ろし先が未入力です。',
        ];
    }
}
