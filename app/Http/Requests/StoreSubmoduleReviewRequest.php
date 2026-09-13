<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubmoduleReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Role check happens in the controller (needs the submodule's
        // project to check Lead Developer ownership) — this stays true
        // and lets the controller issue the specific 403.
        return true;
    }

    public function rules(): array
    {
        return [
            'decision' => ['required', 'in:Approved,Changes Requested'],

            // Remarks are mandatory when requesting changes, optional
            // (but allowed) on approval.
            'remarks' => [
                'nullable',
                'string',
                'max:2000',
                'required_if:decision,Changes Requested',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'remarks.required_if' => 'Please explain what needs to change before requesting changes.',
        ];
    }
}
