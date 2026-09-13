<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BacklinkCategory extends Model
{
    protected $fillable = [

        'name',
        'description',
        'status'

    ];

    public function inventories()
    {
        return $this->hasMany(
            BacklinkInventory::class
        );
    }
}