<?php

namespace App\Http\Requests\alat;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AlatUpdateRequest extends FormRequest
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
            "kategori_id" => ["nullable", "numeric", Rule::exists("kategoris", "id")],
            "nama" => "nullable|string|max:255",
            "deskripsi" => "nullable|string|max:255",
            "hargaperhari" => "nullable|numeric|min:0",
            "stok" => "nullable|numeric|min:0",
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag(),
        ], 400))
        ;
    }
}
