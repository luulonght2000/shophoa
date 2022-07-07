<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required|max:50',
            'category_id' => 'required',
            'style_id' => 'required',
            'price' => 'required|max:30',
            'old_price' => 'required|max:30',
            'avatar' => 'required',
            'avatar' => 'mimes:jpeg, bmp, png, gif, jpg'
        ];
    }
}
