<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndicatorFormRequest extends FormRequest
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
			'description' => $isRequired.'string',
			'result_level' => $isRequired.'string',
			'data_type' => $isRequired.'string',
			'unit' => $isRequired.'string',
			'baseline' => $isRequired.'string',
			'target' => $isRequired.'string',
			'current_value' => $isRequired.'string',
			'frequency' => $isRequired.'string',
			'status' => $isRequired.'string',
            'project_id' => $isRequired.'exists:projects,id'

        ];
    }
    public function prepareForValidation()
    {
        $this->merge([

        ]);
    }
}
