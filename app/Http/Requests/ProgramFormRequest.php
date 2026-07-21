<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProgramFormRequest extends FormRequest
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
            'name' => $isRequired.'string|unique',
			// 'code' => $isRequired.'string',
			'description' => 'nullable|string',
			'budget' => $isRequired.'numeric',
			'donor' => $isRequired.'string',
			'currency' => $isRequired.'string',
			'funding_partner' => $isRequired.'string',
			'start_date' => $isRequired.'nullable|date',
			'end_date' => $isRequired.'nullable|date|after_or_equal:start_date',
			'status' => $isRequired.'in:draft,active,completed,suspended'

        ];
    }
    public function prepareForValidation()
    {
        $this->merge([

        ]);
    }
}
