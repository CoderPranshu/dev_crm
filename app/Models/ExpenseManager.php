<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpenseManager extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'amount', 'expense_category','user_id', 'note', 'date'
    ];
}
