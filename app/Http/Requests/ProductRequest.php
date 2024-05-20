<?php

namespace App\Http\Requests;

use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
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
        $rules = [
            'product_category_id' => 'required',
            'name' => 'required',
            'price' => 'required|numeric',
        ];
        if ($this->isMethod('POST')) {
            $rules['image'] = 'required|mimes:jpeg,jpg,png|max:5000';
        } else {
            $rules['image'] = 'mimes:jpeg,jpg,png|max:5000';
        }
        return $rules;
    }

    public function messages(): array
    {
        return [
            'product_category_id.required'     => 'ID kategori produk harus diisi',
            'name.required'     => 'Nama kategori produk harus diisi',
            'price.required'     => 'Harga kategori produk harus diisi',
            'price.numeric'     => 'Harga kategori produk harus berupa angka',
            'image.mimes'     => 'Gambar harus berupa JPG|JPEG|PNG.',
            'image.required'     => 'Gambar harus diisi.',
        ];
    }

    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->error($validator->errors(), 400));
    }
}
