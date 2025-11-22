<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'           => 'required|string|min:3|max:255',
            'slug'           => 'required|string|max:255|unique:products',
            'description'    => 'nullable|string|max:1000',
            'price'          => 'required|numeric|min:0|max:99999999.99',
            'cost_price'     => 'required|numeric|min:0|max:99999999.99',
            'stock_quantity' => 'required|integer|min:0',
            'category_id'    => 'nullable|integer|exists:categories,id',
        ];
    }

    public function messages(): array
    {
        return [
            'price.max' => 'O preço não pode ser maior que R$ 99.999.999,99',
            'cost_price.max' => 'O preço de custo não pode ser maior que R$ 99.999.999,99',
        ];
    }
}
