<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\{Candidate};

class ShortListController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('Admin')) {
            $shortlists = Candidate::where('is_final', 'yes')
                ->whereNull('onboarding')
                ->latest()
                ->get();
        } elseif ($user->is_manager == 1) {
            $shortlists = Candidate::where('is_final', 'yes')
                ->whereNull('onboarding')
                ->whereHas('recruitment', function ($query) use ($user) {
                    $query->where('manager_id', $user->id);
                })
                ->latest()
                ->get();
        } else {
            $shortlists = Candidate::where('is_final', 'yes')
                ->whereNull('onboarding')
                ->whereHas('recruitment', function ($query) use ($user) {
                    $query->where('branch_id', $user->branch_id);
                })
                ->latest()
                ->get();
        }

        return view('admin.shortlist.index', compact('shortlists'));
    }
}
