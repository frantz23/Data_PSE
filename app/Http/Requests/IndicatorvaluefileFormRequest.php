<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class IndicatorvaluefileFormRequest extends FormRequest
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
        $isRequired = request()->isMethod("POST") ? "required|" : "";
        return [
            //
            'indicator_value_id' => $isRequired . 'exists:indicator_values,id',
            // 'file_name' => $isRequired.'string',
            // 'file_path' => $isRequired.'string',
            // 'mime_type' => $isRequired.'string',
            // 'file_size' => $isRequired.'string'
            'files' => $isRequired.'array',
            'files.*' => 'file|mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,zip|max:10240',

        ];
    }
    public function prepareForValidation()
    {
        $this->merge([]);
    }
}
