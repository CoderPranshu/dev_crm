<?php

namespace App\Http\Requests;

class UpdateKeywordRequest extends StoreKeywordRequest
{
    // Inherits identical validation rules from StoreKeywordRequest.
    // Kept as a separate class so update-specific rules can diverge later
    // (e.g. unique-ignore rules) without touching the create flow.
}