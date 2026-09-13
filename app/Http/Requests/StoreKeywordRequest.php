<?php

namespace App\Http\Requests;

use App\Models\Keyword;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreKeywordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Adjust to your policy/gate structure if required
    }

    public function rules(): array
    {
        return [
            'seo_plan_client_id' => ['required', 'integer', 'exists:seo_plan_clients,id'],
            'keyword'             => ['required', 'string', 'max:255'],
            'location'            => ['nullable', 'string', 'max:150'],
            'language'            => ['nullable', 'string', 'max:100'],
            'search_engine'       => ['nullable', 'string', 'max:100'],
            'device'              => ['required', Rule::in(Keyword::DEVICES)],
            'priority'            => ['required', Rule::in(Keyword::PRIORITIES)],
            'status'              => ['required', Rule::in(Keyword::STATUSES)],
            'search_volume'       => ['nullable', 'integer', 'min:0'],
            'keyword_difficulty'  => ['nullable', 'integer', 'min:0', 'max:100'],
            'cpc'                 => ['nullable', 'numeric', 'min:0'],
            'current_rank'        => ['nullable', 'integer', 'min:0'],
            'target_rank'         => ['nullable', 'integer', 'min:0'],
            'landing_page'        => ['nullable', 'string', 'max:255'],
            'intent'              => ['nullable', Rule::in(Keyword::INTENTS)],
            'remarks'             => ['nullable', 'string'],
        ];
    }

    public function messages(): array
    {
        return [
            'keyword.required'             => 'The keyword field is required.',
            'seo_plan_client_id.required'  => 'Please select the SEO project this keyword belongs to.',
            'seo_plan_client_id.exists'    => 'The selected SEO project is invalid.',
        ];
    }

    protected function prepareForValidation(): void
{
    $seoPlanClient = $this->route('seo_plan_client');

    if ($seoPlanClient) {
        $this->merge([
            'seo_plan_client_id' => $seoPlanClient->id,
        ]);
    }
}
}