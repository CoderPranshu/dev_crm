<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use App\Models\SubscriptionItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SubscriptionDomainStatusController extends Controller
{
    public function __invoke(Request $request, Subscription $subscription)
    {
        abort_unless($request->user()?->role === 'admin', 403);

        $validated = $request->validate([
            'domain_name' => 'required|string|max:255',
            'status'      => 'required|in:active,inactive',
        ]);

        $domainName = trim($validated['domain_name']);

        if ($domainName === '') {
            throw ValidationException::withMessages([
                'domain_name' => 'Choose a valid domain.',
            ]);
        }

        DB::transaction(function () use ($subscription, $domainName, $validated) {
            $ids = SubscriptionItem::query()
                ->where('subscription_id', $subscription->id)
                ->where('domain_name', $domainName)
                ->lockForUpdate()
                ->pluck('id');

            if ($ids->isEmpty()) {
                throw ValidationException::withMessages([
                    'domain_name' => 'Domain does not belong to this subscription.',
                ]);
            }

            SubscriptionItem::query()
                ->whereIn('id', $ids)
                ->update(['domain_status' => $validated['status']]);
        });

        return back()->with('success', 'Domain status updated successfully.');
    }
}