<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SpecialDay;
use Illuminate\Http\Request;

class SpecialDayController extends Controller
{
    // public function index()
    // {
    //     $todayDays = SpecialDay::query()
    //         ->active()
    //         ->today()
    //         ->orderByDesc('is_major')
    //         ->orderBy('title')
    //         ->get();

    //     $nextSevenDays = SpecialDay::query()
    //         ->active()
    //         ->upcoming(7)
    //         ->get();

    //     $nextThirtyDays = SpecialDay::query()
    //         ->active()
    //         ->upcoming(30)
    //         ->get();

    //     $nextOccasion = $nextThirtyDays->first();

    //     return view('admin.special-days.index', compact(
    //         'todayDays',
    //         'nextSevenDays',
    //         'nextThirtyDays',
    //         'nextOccasion'
    //     ));
    // }

    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | Allowed filters
        |--------------------------------------------------------------------------
        | 365 days se zyada ka filter allow nahi hoga.
        */

        $allowedDays = [
            7,
            15,
            30,
            60,
            90,
            180,
            365,
        ];

        $filterDays = (int) $request->get('days', 30);

        if (!in_array($filterDays, $allowedDays, true)) {
            $filterDays = 30;
        }

        // Aaj ke special days
        $todayDays = SpecialDay::query()
            ->active()
            ->today()
            ->orderByDesc('is_major')
            ->orderBy('title')
            ->get();

        // Fixed next 7 days section
        $nextSevenDays = SpecialDay::query()
            ->active()
            ->upcoming(7)
            ->get();

        // Selected filter ke according upcoming days
        $filteredUpcomingDays = SpecialDay::query()
            ->active()
            ->upcoming($filterDays)
            ->get();

        // Agle 365 din ke andar nearest occasion
        $nextOccasion = SpecialDay::query()
            ->active()
            ->upcoming(365)
            ->first();

        return view('admin.special-days.index', compact(
            'todayDays',
            'nextSevenDays',
            'filteredUpcomingDays',
            'nextOccasion',
            'filterDays',
            'allowedDays'
        ));
    }


}






