<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'source',
        'deal_id',
        'client_name',
        'company_name',
        'office_name',
        'phone',
        'email',
        'address',
        'country',
        'project_name',
        'project_description',
        'department_id',
        'assigned_to',
        'start_date',
        'deadline',
        'priority',
        'status',
        'remarks',
        'attachments',
        'created_by',
    ];

    protected $casts = [
        'start_date' => 'date',
        'deadline' => 'date',
        // 'attachments' => 'array',
    ];

    public function attachments()
    {
        return $this->hasMany(ProjectAttachment::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function modules()
    {
        return $this->hasMany(ProjectModule::class);
    }

    public function leadDeveloper()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }

    public function assignments()
    {
        return $this->hasMany(ProjectModuleAssignment::class);
    }

    public function messages()
    {
        return $this->hasMany(ProjectMessage::class);
    }

}
