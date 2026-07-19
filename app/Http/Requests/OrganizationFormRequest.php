<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrganizationFormRequest extends FormRequest
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
            'name' => $isRequired.'string',
			'slug' => $isRequired.'',
			'description' => $isRequired.'string',
			'email' => $isRequired.'email',
			'phone' => $isRequired.'string',
			'website' => $isRequired.'string',
			'country' => $isRequired.'string',
			'city' => $isRequired.'string',
			'address' => $isRequired.'string',
			'logo' => $isRequired.'string',
			'primary_color' => $isRequired.'string',
			'status' => $isRequired.'string'
			
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'slug' => \Illuminate\Support\Str::slug($this->input('name')),
			
        ]);
    }
}