<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payslip extends Model
{
    use HasFactory;

    protected $fillable = [
        'uan_no',
        'esi_no',
        'hra',
        'conveyance_allowance',
        'other_allowance',
        'gross_salary',
        'pf',
        'esi',
        'tax',
        'tds',
        'other_deduc',
        'total_deduc',
        'total_net',
        'working_days',
        'present_days',
        'leave_withoutpay',
        'over_time',
        'final_payable',
        'payment_mode',
        'payment_date',
        'remark',
        'approved_by',
        'brief_of_monthly_salary'
    ];
}
