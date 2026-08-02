<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectFormRequest extends FormRequest
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
        $projectId = $this->route('project')?->id ?? $this->route('project');

        return [
            //
            // 'name' => $isRequired.'string|unique:projects,name',
            'name' => [
                'required',
                'string',
                Rule::unique('projects', 'name')->ignore($projectId),
            ],
			'code' => $isRequired.'string',
			'description' => $isRequired.'string',
			'budget' => $isRequired.'nullable|numeric',
			'start_date' => $isRequired.'nullable|date',
			'end_date' => $isRequired.'nullable|date|after_or_equal:start_date',
			'status' => $isRequired.'in:draft,active,completed,suspended',
            'program_id' => $isRequired.'exists:programs,id'

        ];
    }
    public function prepareForValidation()
    {
        $this->merge([

        ]);
    }
}
