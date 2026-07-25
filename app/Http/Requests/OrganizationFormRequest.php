<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $isRequired = request()->isMethod("POST") ? "required|" : "";
        // Récupère l'ID depuis la route (ex: /organizations/delete/{organization} ou /organizations/{organization})
        $organizationId = $this->route('organization')?->id ?? $this->route('organization');
        return [
            //
            'name' => $isRequired . 'string',
            'slug' => $isRequired . '',
            'description' => $isRequired . 'string',
            // --- Champ Email sécurisé pour la modification ---
            'email' => [
                'required',
                'email',
                'max:255',
                // On dit à Laravel : "Unique SAUF pour l'organisation actuelle"
                Rule::unique('organizations', 'email')->ignore($organizationId),
            ],
            'phone' => $isRequired . 'string',
            'website' => $isRequired . 'string',
            'country' => $isRequired . 'string',
            'city' => $isRequired . 'string',
            'address' => $isRequired . 'string',
            'logo' => $isRequired . 'file|image|max:2048',
            'primary_color' => [
                'string',
                'regex:/^#([a-fA-F0-9]{6}|[a-fA-F0-9]{3})$/i'
            ],
            'status' => $isRequired . 'string|in:active,inactive,suspended'

        ];
    }
    public function prepareForValidation()
    {
        $this->merge([
            'slug' => \Illuminate\Support\Str::slug($this->input('name')),

        ]);
    }
}
