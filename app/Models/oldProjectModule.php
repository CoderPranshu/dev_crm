<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProjectModule extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'project_id',
        'module_name',
        'module_type',
        'description',
        'department_id',
        'assigned_to',
        'priority',
        'status',
        'progress',
        'estimated_hours',
        'actual_hours',
        'start_date',
        'deadline',
        'color',
        'tags',
        'sort_order',
        'is_active',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be cast.
     *public function latestAssignment()
{
    return $this->hasOne(ProjectModuleAssignment::class)
        ->latestOfMany();
}
     * @var array<string, string>
     */
    protected $casts = [
        'tags' => 'array',
        'is_active' => 'boolean',
        'progress' => 'integer',
        'sort_order' => 'integer',
        'estimated_hours' => 'decimal:2',
        'actual_hours' => 'decimal:2',
        'start_date' => 'date',
        'deadline' => 'date',
        'department_id' => 'integer',
        'assigned_to' => 'integer',
        'project_id' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function developer()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    public function subModules(): HasMany
    {
        return $this->hasMany(ProjectSubModule::class);
    }

    /**
     * Full assignment history for this module (every time it was
     * assigned/reassigned to a developer, and whether they accepted it).
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(ProjectModuleAssignment::class);
    }

    /**
     * Department relationship.
     * Adjust the related model namespace/name to match your actual Department model.
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Department::class, 'department_id');
    }

    /**
     * Assigned developer/user relationship.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_to');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'updated_by');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    public function acceptedAssignment()
    {
        return $this->hasOne(ProjectModuleAssignment::class)
                    ->where('status', 'Accepted');
    }

    public function latestAssignment()
    {
        return $this->hasOne(ProjectModuleAssignment::class)
            ->latestOfMany();
    }

    public function rejectedAssignment()
    {
        return $this->hasOne(ProjectModuleAssignment::class)
            ->where('status','rejected')
            ->latestOfMany();
    }

   public function latestRejectedAssignment()
    {
        return $this->hasOne(ProjectModuleAssignment::class)
            ->where('status','rejected')
            ->latestOfMany();
    }

    public function currentAssignment(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProjectModuleAssignment::class, 'project_module_id')
                    ->where('is_current', true);
    }

    // 

    public function requirements(): HasMany
    {
        return $this->hasMany(Requirement::class);
    }

    public function blockingRequirements(): HasMany
    {
        return $this->hasMany(Requirement::class)
            ->where('is_blocker', true)
            ->whereNotIn('status', ['Completed', 'Rejected']);
    }

    public function isBlocked(): bool
    {
        return $this->blockingRequirements()->exists();
    }
    
}
