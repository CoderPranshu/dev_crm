<?php

namespace App\Support;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

final class SubscriptionDomainAccess
{
    /**
     * Return only the domain items belonging to a subscription linked to $user.
     * Staff/admin roles do not bypass this check.
     *
     * A company's subscription is not automatically available to every user
     * at that company. Prefer an explicit user assignment; for legacy records
     * use the purchaser email already saved with the subscription.
     */
    public static function domainItemsFor(Authenticatable $user): Builder
    {
        $query = DB::table('subscription_items as item')
            ->join('subscriptions as subscription', 'subscription.id', '=', 'item.subscription_id')
            ->whereNotNull('item.domain_name')
            ->whereRaw("TRIM(item.domain_name) <> ''")
            ->where('subscription.status', 'active')
            ->where('item.domain_status', 'active')
            ->whereNotExists(function ($subquery) {
                $subquery->selectRaw('1')
                    ->from('subscription_items as other_item')
                    ->whereColumn('other_item.subscription_id', 'item.subscription_id')
                    ->whereColumn('other_item.domain_name', 'item.domain_name')
                    ->where('other_item.domain_status', '!=', 'active');
            });

        // Conventional many-to-many user/subscription mapping.
        if (Schema::hasTable('subscription_user')
            && Schema::hasColumn('subscription_user', 'subscription_id')
            && Schema::hasColumn('subscription_user', 'user_id')) {
            return $query->whereExists(function ($subquery) use ($user) {
                $subquery->selectRaw('1')
                    ->from('subscription_user as owner')
                    ->whereColumn('owner.subscription_id', 'subscription.id')
                    ->where('owner.user_id', $user->getAuthIdentifier());
            });
        }

        $email = strtolower(trim((string) $user->email));

        // A direct owner takes precedence. For older rows without user_id,
        // recognize only a matching purchaser email.
        if (Schema::hasColumn('subscriptions', 'user_id')) {
            return $query->where(function ($owner) use ($user, $email) {
                $owner->where('subscription.user_id', $user->getAuthIdentifier());

                if ($email !== '') {
                    $owner->orWhere(function ($legacy) use ($email) {
                        $legacy->whereNull('subscription.user_id')
                            ->whereRaw('LOWER(TRIM(subscription.email)) = ?', [$email]);
                    });
                }
            });
        }

        // The provided subscription form stores the customer's email, even
        // though it does not store a user_id. Match only that signed-in user.
        if ($email !== '') {
            return $query->whereRaw('LOWER(TRIM(subscription.email)) = ?', [$email]);
        }

        // No individual owner identity: deny access.
        return $query->whereRaw('1 = 0');
    }
}
