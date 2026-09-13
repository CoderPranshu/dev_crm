<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeadImportBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'original_file_name',
        'stored_file_name',
        'file_path',
        'file_type',
        'file_size',
        'total_rows',
        'imported_rows',
        'skipped_rows',
        'sales_user_id',
        'category_id',
        'uploaded_by',
        'branch_id',
        'status',
    ];

    public function leads()
    {
        return $this->hasMany(Lead::class, 'import_batch_id');
    }

    public function salesUser()
    {
        return $this->belongsTo(User::class, 'sales_user_id');
    }

    public function category()
    {
        return $this->belongsTo(LeadCategory::class, 'category_id');
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}


