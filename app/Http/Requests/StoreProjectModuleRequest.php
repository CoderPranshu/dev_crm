<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreProjectModuleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * Adjust this to your actual authorization policy (e.g. Gate/Policy check).
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Prepare the data for validation.
     * Normalizes tags (comma separated string or array) before validation runs.
     */
    protected function prepareForValidation(): void
    {
        $modules = $this->input('modules', []);

        foreach ($modules as $index => $module) {
            // Normalize tags: accept comma-separated string from a text input
            // or an already-structured array (e.g. from a tags/chips JS plugin).
            if (isset($module['tags']) && is_string($module['tags'])) {
                $modules[$index]['tags'] = array_values(array_filter(
                    array_map('trim', explode(',', $module['tags']))
                ));
            }

            // Normalize color to ensure it always has a leading #
            if (!empty($module['color']) && !str_starts_with($module['color'], '#')) {
                $modules[$index]['color'] = '#' . ltrim($module['color'], '#');
            }
        }

        $this->merge(['modules' => $modules]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],

            // Modules
            'modules' => ['required', 'array', 'min:1'],
            'modules.*.module_name' => ['required', 'string', 'max:255'],
            'modules.*.module_type' => ['nullable', 'string', 'max:255'],
            'modules.*.description' => ['nullable', 'string'],
            'modules.*.department_id' => ['nullable', 'integer', 'exists:departments,id'],
            'modules.*.assigned_to' => ['nullable', 'integer', 'exists:users,id'],
            'modules.*.priority' => ['required', 'in:low,medium,high,critical'],
            'modules.*.status' => ['required', 'in:pending,in_progress,completed,on_hold,cancelled'],
            'modules.*.progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'modules.*.estimated_hours' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'modules.*.actual_hours' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'modules.*.start_date' => ['nullable', 'date'],
            'modules.*.deadline' => ['nullable', 'date', 'after_or_equal:modules.*.start_date'],
            'modules.*.color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'modules.*.tags' => ['nullable', 'array'],
            'modules.*.tags.*' => ['string', 'max:50'],
            'modules.*.attachments' => ['nullable', 'array'],
            'modules.*.attachments.*' => ['file', 'max:10240', 'mimes:pdf,doc,docx,xls,xlsx,png,jpg,jpeg,zip'],
            'modules.*.is_active' => ['nullable', 'boolean'],

            // Sub modules (nested under each module)
            'modules.*.sub_modules' => ['nullable', 'array'],
            'modules.*.sub_modules.*.sub_module_name' => ['required', 'string', 'max:255'],
            'modules.*.sub_modules.*.description' => ['nullable', 'string'],
            'modules.*.sub_modules.*.assigned_to' => ['nullable', 'integer', 'exists:users,id'],
            'modules.*.sub_modules.*.priority' => ['required', 'in:low,medium,high,critical'],
            'modules.*.sub_modules.*.status' => ['required', 'in:pending,in_progress,completed,on_hold,cancelled'],
            'modules.*.sub_modules.*.progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'modules.*.sub_modules.*.estimated_hours' => ['nullable', 'numeric', 'min:0', 'max:99999.99'],
            'modules.*.sub_modules.*.start_date' => ['nullable', 'date'],
            'modules.*.sub_modules.*.deadline' => [
                'nullable',
                'date',
                'after_or_equal:modules.*.sub_modules.*.start_date',
            ],
            'modules.*.sub_modules.*.is_active' => ['nullable', 'boolean'],
        ];
    }

    /**
     * Custom validation error messages for clearer feedback in the UI.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'modules.required' => 'Please add at least one module before saving.',
            'modules.min' => 'Please add at least one module before saving.',
            'modules.*.module_name.required' => 'Module name is required for every module.',
            'modules.*.priority.required' => 'Priority is required for every module.',
            'modules.*.status.required' => 'Status is required for every module.',
            'modules.*.deadline.after_or_equal' => 'Deadline must be the same as or after the start date.',
            'modules.*.sub_modules.*.sub_module_name.required' => 'Sub module name is required.',
            'modules.*.sub_modules.*.deadline.after_or_equal' => 'Sub module deadline must be the same as or after its start date.',
        ];
    }

    /**
     * Custom attribute names so error messages read naturally.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'modules.*.module_name' => 'module name',
            'modules.*.sub_modules.*.sub_module_name' => 'sub module name',
        ];
    }

    /**
     * Return validation errors as JSON when the request expects JSON
     * (useful if the form is submitted via AJAX/fetch).
     */
    protected function failedValidation(Validator $validator): void
    {
        if ($this->expectsJson()) {
            throw new HttpResponseException(response()->json([
                'success' => false,
                'message' => 'Validation failed. Please check the highlighted fields.',
                'errors' => $validator->errors(),
            ], 422));
        }

        parent::failedValidation($validator);
    }
}