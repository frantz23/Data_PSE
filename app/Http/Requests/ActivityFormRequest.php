<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityFormRequest extends FormRequest
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
			'budget' => $isRequired.'string',
			'start_date' => $isRequired.'string',
			'end_date' => $isRequired.'string',
			'status' => $isRequired.'string',
			'completion_rate' => $isRequired.'string',
			// 'user_id' => $isRequired.'string',
			'assigned_to' => $isRequired.'string',
			'parent_activity_id' => 'nullable|integer|exists:activities,id',
			'project_id' => $isRequired.'exists:projects,id'
        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            
        ]);
    }
}