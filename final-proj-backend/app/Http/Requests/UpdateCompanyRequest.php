<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCompanyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"=> "required|min:2",
            "slug"=> "required",
            "image"=> "nullable|url|max:255",
            "city"=> "required|max:255",
            "address"=> "required|max:255",
            "vat_number"=> "required|max:11",
            "description"=> "nullable|max:2500",
            "phone_number"=> "required|max:50",
            "email"=> "required|max:255",

        ];
    }
}
