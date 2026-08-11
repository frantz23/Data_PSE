<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DonorFormRequest extends FormRequest
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
        $isRequired = request()->isMethod("POST") ?"required|": "";
        return [
            //
            'code' => $isRequired.'string',
			'name' => $isRequired.'string',
			'type' => $isRequired.'string',
			'email' => $isRequired.'email',
			'phone' => $isRequired.'string',
			'website' => $isRequired.'string',
			'address' => $isRequired.'string',
			'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
			'isActive' => $isRequired.'in:true,false|nullable'

        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'isActive' => $this->input('isActive') ? 'true' : 'false',

        ]);
    }
}
