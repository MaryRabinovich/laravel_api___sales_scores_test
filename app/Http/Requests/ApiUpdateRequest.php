<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiUpdateRequest extends FormRequest
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
            'id' => 'required|integer|min:1',
            'client_id' => 'required|integer|min:1',

            'items' => 'required|array',
            'items.*.article' => 'required|string|min:1',
            'items.*.name' => 'required|string|min:1',
            'items.*.price' => 'required|integer|min:1',
            'items.*.quantity' => 'required|integer|min:1',

            'status' => 'required|in:new,accepted,shipping'
        ];
    }
}
