<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BacklinkAssignment extends Model
{
    use HasFactory;

    protected $fillable = [

        'seo_plan_client_id',
        'client_backlink_import_id',
        'backlink_id',
        'assigned_to',
        'assigned_by',
        'username',
        'password',
        'attachment',
        'remarks',
        'status',
        'assigned_at',
        'completed_at',
        'completed_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | SEO Project
    |--------------------------------------------------------------------------
    */

    public function seoPlanClient()
    {
        return $this->belongsTo(
            SeoPlanClient::class,
            'seo_plan_client_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Backlink
    |--------------------------------------------------------------------------
    */

    public function backlink()
    {
        return $this->belongsTo(
            Backlink::class,
            'backlink_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Assigned SEO Executive
    |--------------------------------------------------------------------------
    */

    public function assignedUser()
    {
        return $this->belongsTo(
            User::class,
            'assigned_to'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Assigned By
    |--------------------------------------------------------------------------
    */

    public function assignedBy()
    {
        return $this->belongsTo(
            User::class,
            'assigned_by'
        );
    }

    public function completedByUser()
    {
        return $this->belongsTo(User::class, 'completed_by');
    }

     /**
     * Source CSV / Excel import used to create this assignment.
     */
    public function backlinkImport(): BelongsTo
    {
        return $this->belongsTo(ClientBacklinkImport::class, 'client_backlink_import_id');
    }


}