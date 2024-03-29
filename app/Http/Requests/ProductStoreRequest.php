<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ProductStoreRequest extends FormRequest
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
     * @return array
     */
    public function rules()
    {
        return [
        'product_name' => 'required|max:255',
        'price' => 'required|numeric|min:0',
        'stock' => 'required|numeric|min:0',
        'img_path' => 'required|image',
        'company_id' => 'required|exists:companies,id',
        ];
    }
}
