<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'phone', 'email', 'address', 'categories_id', 'status',
        'user_id', 'remarks', 'call_again', 'requirement', 'call_schedule',
        'follow_up_priority', 'pending_call_action', 'branch_id', 'source', 'import_batch_id',
    ];

    public function leadcat() { return $this->belongsTo(LeadCategory::class, 'categories_id'); }
    // public function deals() { return $this->hasMany(Deal::class); }
     public function deals()
    {
        return $this->hasMany(Deal::class, 'leads_id', 'id');
    }
    public function userlead() { return $this->belongsTo(User::class, 'user_id'); }
    public function branch() { return $this->belongsTo(Branch::class); }
    public function assignedUser() { return $this->belongsTo(User::class, 'user_id'); }
    public function quotations() { return $this->hasMany(Quotation::class, 'lead_id'); }
    // public function actions() { return $this->hasMany(LeadAction::class, 'lead_id')->latest('action_at'); }
    public function actions()
    {
        return $this->hasMany(LeadAction::class, 'lead_id', 'id');
    }
    public function latestAction() { return $this->hasOne(LeadAction::class, 'lead_id')->latestOfMany(); }
    public function importBatch() { return $this->belongsTo(LeadImportBatch::class, 'import_batch_id'); }
    public function latestNote() { return $this->hasOne(LeadNote::class, 'lead_id')->latestOfMany(); }
    public function notes() { return $this->hasMany(LeadNote::class, 'lead_id'); }
}




