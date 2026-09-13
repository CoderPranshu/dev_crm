<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Keyword;

use App\Models\SeoProjectKeyword;

use App\Models\SeoProjectLocation;





class SeoPlanClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'seo_plan_id',
        'company_id',
        'start_date',
        'end_date',
        'status',
        'team_id',
    ];

    public function team()
    {
        return $this->belongsTo(User::class,'team_id');
    }

    // public function plan()
    // {
    //     return $this->belongsTo(SeoPlan::class, 'seo_plan_id');
    // }

    // public function company()
    // {
    //     return $this->belongsTo(Company::class);
    // }

    // public function seoPlan()
    // {
    //     return $this->belongsTo(SeoPlan::class);
    // }

    public function company()
    {
        return $this->belongsTo(Company::class,'company_id');
    }

    public function seoPlan()
    {
        return $this->belongsTo(SeoPlan::class);
    }

    public function works()
    {
        return $this->hasMany(SeoTeamWork::class, 'seo_plan_client_id');
    }


    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'team_id');
    }

    public function distributions()
    {
        return $this->hasMany(SeoTaskDistribution::class, 'seo_plan_client_id');
    }

    public function backlinkAssignments()
    {
        return $this->hasMany(
            BacklinkAssignment::class,
            'seo_plan_client_id'
        );
    }

    public function seoExecutive()
    {
        return $this->belongsTo(User::class, 'seo_team_id');
    }

    // public function keywords(): HasMany
    // {
    //     return $this->hasMany(Keyword::class);
    // }

    public function keywords(): HasMany
    {
        return $this->hasMany(
            SeoProjectKeyword::class,
            'seo_plan_client_id'
        );
    }

    public function locations(): HasMany
    {
        return $this->hasMany(
            SeoProjectLocation::class,
            'seo_plan_client_id'
        );
    }




}
