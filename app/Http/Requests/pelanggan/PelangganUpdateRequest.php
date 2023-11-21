<?php

namespace App\Http\Requests\pelanggan;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PelangganUpdateRequest extends FormRequest
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
            "nama" => "nullable|string|max:150",
            "alamat" => "nullable|string|max:200",
            "notelp" => "nullable|string|max:13",
            "email" => "nullable|string|email|max:100|unique:pelanggans",
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response([
            "errors" => $validator->getMessageBag(),
        ], 400));
    }
}
