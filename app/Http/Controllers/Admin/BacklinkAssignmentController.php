<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\SeoPlanClient;

use App\Models\User;

use App\Models\Backlink;

use App\Models\BacklinkAssignment;

use Illuminate\Support\Facades\DB;


use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;




class BacklinkAssignmentController extends Controller
{
    // public function index($id)
    // {
    //     $project = SeoPlanClient::with([
    //         'company',
    //         'seoPlan',
    //         'team'
    //     ])->findOrFail($id);

    //     return $project;

    //     /*
    //     |--------------------------------------------------------------------------
    //     | SEO Executives
    //     |--------------------------------------------------------------------------
    //     */

    //     // $executives = User::whereHas('designation', function ($q) {

    //     //     $q->where('name', 'SEO');

    //     // })->orderBy('name')->get();

    //     $executives = User::whereHas('department', function ($query) {
    //                                 $query->where('department', '13');
    //                             })
    //                             ->orderBy('name')
    //                             ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Available Backlinks
    //     |--------------------------------------------------------------------------
    //     */

    //     $availableBacklinks = Backlink::with('category')

    //         ->where('status', 'available')

    //         ->latest()

    //         ->paginate(20);

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Assigned Backlinks
    //     |--------------------------------------------------------------------------
    //     */

    //     $assignedBacklinks = BacklinkAssignment::with([

    //         'backlink.category',

    //         'assignedUser'

    //     ])

    //     ->where('seo_plan_client_id', $project->id)

    //     ->latest()

    //     ->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Cards
    //     |--------------------------------------------------------------------------
    //     */

    //     $totalBacklinks = Backlink::count();

    //     // $availableCount = Backlink::where('status', 'available')->count();
    //     $assignedIds = BacklinkAssignment::where('seo_plan_client_id', $project->id)
    //         ->pluck('backlink_id');

    //     $availableCount = Backlink::whereNotIn('id', $assignedIds)->count();

    //    $assignedCount = BacklinkAssignment::where('seo_plan_client_id', $project->id)
    //                                                         ->where('status', 'assigned')
    //                                                         ->count();

    //     $completedCount = BacklinkAssignment::where('seo_plan_client_id', $project->id)
    //                                                         ->where('status', 'completed')
    //                                                         ->count();

    //     return view(

    //         'admin.backlink-assignment.index',

    //         compact(

    //             'project',

    //             'executives',

    //             'availableBacklinks',

    //             'assignedBacklinks',

    //             'totalBacklinks',

    //             'availableCount',

    //             'assignedCount',

    //             'completedCount'

    //         )

    //     );
    // }

    // public function index($id)
    // {
    //     $project = SeoPlanClient::with([
    //         'company',
    //         'seoPlan',
    //         'team',
    //         'distributions',
    //     ])->findOrFail($id);

    //     // return $project;

    //     $authUser = auth()->user();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Permission Scope
    //     |--------------------------------------------------------------------------
    //     | - Admin                              => full access (sees everything)
    //     | - Project's assigned Team (team_id)  => full access (sees everything)
    //     | - Any other SEO executive            => sees ONLY backlinks assigned
    //     |                                          to themselves (assigned_to)
    //     |--------------------------------------------------------------------------
    //     */

    //     $isAdmin = $authUser->role == 'admin'; // <-- adjust to match your actual admin check (see note below)

    //     $isProjectTeam = (int) $project->team_id === (int) $authUser->id;

    //     $hasFullAccess = $isAdmin || $isProjectTeam;

    //     /*
    //     |--------------------------------------------------------------------------
    //     | SEO Executives
    //     |--------------------------------------------------------------------------
    //     */

    //     $executives = User::whereHas('department', function ($query) {
    //         $query->where('department', '13');
    //     })->orderBy('name')->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Available Backlinks
    //     |--------------------------------------------------------------------------
    //     */

    //     $availableBacklinks = Backlink::with('category')
    //         ->where('status', 'available')
    //         ->latest()
    //         ->paginate(20);

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Assigned Backlinks (permission-scoped)
    //     |--------------------------------------------------------------------------
    //     */

    //     $assignedBacklinksQuery = BacklinkAssignment::with([
    //         'backlink.category',
    //         'assignedUser'
    //     ])
    //     ->where('seo_plan_client_id', $project->id);

    //     if (!$hasFullAccess) {
    //         $assignedBacklinksQuery->where('assigned_to', $authUser->id);
    //     }

    //     $assignedBacklinks = $assignedBacklinksQuery->latest()->get();

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Cards (scoped the same way, so the numbers match what's on screen)
    //     |--------------------------------------------------------------------------
    //     */

    //     $totalBacklinks = Backlink::count();

    //     $assignedIds = BacklinkAssignment::where('seo_plan_client_id', $project->id)
    //         ->pluck('backlink_id');

    //     $availableCount = Backlink::whereNotIn('id', $assignedIds)->count();

    //     $assignedCountQuery = BacklinkAssignment::where('seo_plan_client_id', $project->id)
    //         ->where('status', 'assigned');

    //     $completedCountQuery = BacklinkAssignment::where('seo_plan_client_id', $project->id)
    //         ->where('status', 'completed');

    //     if (!$hasFullAccess) {
    //         $assignedCountQuery->where('assigned_to', $authUser->id);
    //         $completedCountQuery->where('assigned_to', $authUser->id);
    //     }

    //     $assignedCount  = $assignedCountQuery->count();
    //     $completedCount = $completedCountQuery->count();

    //     return view(
    //         'admin.backlink-assignment.index',
    //         compact(
    //             'project',
    //             'executives',
    //             'availableBacklinks',
    //             'assignedBacklinks',
    //             'totalBacklinks',
    //             'availableCount',
    //             'assignedCount',
    //             'completedCount',
    //             'hasFullAccess',
    //         )
    //     );
    // }


    // public function store(Request $request)
    // {

       
    //     $request->validate([

    //         'seo_plan_client_id' => 'required|exists:seo_plan_clients,id',

    //         'assigned_to'        => 'required|exists:users,id',

    //         'backlinks'          => 'required|array|min:1',

    //         'backlinks.*'        => 'exists:backlinks,id',

    //     ]);

    //     DB::beginTransaction();

    //     try {

    //         foreach ($request->backlinks as $backlinkId) {

    //             $backlink = Backlink::find($backlinkId);

    //             if (!$backlink) {
    //                 continue;
    //             }

    //             // Already assigned skip
    //             if ($backlink->status == 'assigned') {
    //                 continue;
    //             }

    //             BacklinkAssignment::create([

    //                 'seo_plan_client_id' => $request->seo_plan_client_id,

    //                 'backlink_id'        => $backlinkId,

    //                 'assigned_to'        => $request->assigned_to,

    //                 'assigned_by'        => auth()->id(),

    //                 // Complete hone par fill honge
    //                 'username'           => null,
    //                 'password'           => null,
    //                 'attachment'         => null,
    //                 'remarks'            => null,

    //                 'status'             => 'assigned',

    //                 'assigned_at'        => now(),

    //                 'completed_at'       => null,

    //             ]);

    //             // $backlink->update([

    //             //     'status' => 'assigned',

    //             // ]);
    //         }

    //         DB::commit();

    //         return back()->with(
    //             'success',
    //             'Backlinks assigned successfully.'
    //         );

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return back()->with(
    //             'error',
    //             $e->getMessage()
    //         );
    //     }
    // }

    // public function complete(Request $request, $id)
    // {

    //     $request->validate([
    //         'username'   => 'required|string|max:255',
    //         'password'   => 'required|string|max:255',
    //         'attachment' => 'nullable|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
    //         'remarks'    => 'nullable|string',
    //     ]);

    //     DB::beginTransaction();

    //     try {

    //         $assignment = BacklinkAssignment::with('backlink')->findOrFail($id);

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Upload Screenshot
    //         |--------------------------------------------------------------------------
    //         */

    //         $attachment = $assignment->attachment;

    //         if ($request->hasFile('attachment')) {

    //             if (
    //                 $attachment &&
    //                 Storage::disk('public')->exists($attachment)
    //             ) {
    //                 Storage::disk('public')->delete($attachment);
    //             }

    //             $attachment = $request
    //                 ->file('attachment')
    //                 ->store('backlinks', 'public');
    //         }

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Update Assignment
    //         |--------------------------------------------------------------------------
    //         */

    //         $assignment->update([

    //             'username'     => $request->username,

    //             'password'     => $request->password,

    //             'attachment'   => $attachment,

    //             'remarks'      => $request->remarks,

    //             'status'       => 'completed',

    //             'completed_at' => Carbon::now(),

    //         ]);

    //         /*
    //         |--------------------------------------------------------------------------
    //         | Update Inventory
    //         |--------------------------------------------------------------------------
    //         */

    //         // if ($assignment->backlink) {

    //         //     $assignment->backlink->update([

    //         //         'status' => 'completed',

    //         //     ]);
    //         // }

    //         DB::commit();

    //         return redirect()
    //             ->back()
    //             ->with('success', 'Backlink completed successfully.');

    //     } catch (\Exception $e) {

    //         dd($e->getMessage(), $e->getTraceAsString());
    //     }
        
    // }

    // public function inlineUpdate(Request $request, $id)
    // {
    //     $assignment = BacklinkAssignment::with('backlink')->findOrFail($id);

    //     $field = $request->input('field');

    //     $allowedFields = ['username', 'password', 'remarks', 'status', 'attachment'];

    //     if (!in_array($field, $allowedFields)) {
    //     return response()->json([
    //     'message' => 'Invalid field.',
    //     ], 422);
    //     }

    //     switch ($field) {

    //     case 'username':
    //     $request->validate([
    //     'value' => 'required|string|max:255',
    //     ]);
    //     $assignment->username = $request->input('value');
    //     break;

    //     case 'password':
    //     $request->validate([
    //     'value' => 'required|string|max:255',
    //     ]);
    //     $assignment->password = $request->input('value');
    //     break;

    //     case 'remarks':
    //     $request->validate([
    //     'value' => 'nullable|string',
    //     ]);
    //     $assignment->remarks = $request->input('value');
    //     break;

    //     case 'status':
    //     $request->validate([
    //     'value' => 'required|in:assigned,completed',
    //     ]);

    //     $assignment->status = $request->input('value');

    //     $assignment->completed_at = $request->input('value') === 'completed'
    //     ? Carbon::now()
    //     : null;

    //     break;

    //     case 'attachment':
    //     $request->validate([
    //     'attachment' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
    //     ]);

    //     if (
    //     $assignment->attachment &&
    //     Storage::disk('public')->exists($assignment->attachment)
    //     ) {
    //     Storage::disk('public')->delete($assignment->attachment);
    //     }

    //     $assignment->attachment = $request
    //     ->file('attachment')
    //     ->store('backlinks', 'public');

    //     break;
    //     }

    //     $assignment->save();

    //     return response()->json([
    //     'message' => 'Updated successfully.',
    //     'field' => $field,
    //     'status' => $assignment->status,
    //     'attachment_url' => $assignment->attachment ? asset('storage/'.$assignment->attachment) : null,
    //     'attachment_name' => $assignment->attachment ? basename($assignment->attachment) : null,
    //     ]);
    // }



    // 


   public function index($id)
{
    $project = SeoPlanClient::with([
        'company',
        'seoPlan',
        'team',
        'distributions',
    ])->findOrFail($id);

    $authUser = auth()->user();

    $distributionUserIds = $project->distributions->pluck('user_id')->unique()->values();

    $isAdmin = $authUser->role == 'admin'; // apna actual admin check yahan lagana

    $canAccess = $isAdmin || $distributionUserIds->contains($authUser->id);

    abort_unless($canAccess, 403, 'You do not have access to this project.');

    /*
    |--------------------------------------------------------------------------
    | Auto-sync: har available backlink jo abhi tak is project se assign
    | nahi hai, use automatically assign kar do — koi manual "Add" step nahi.
    |--------------------------------------------------------------------------
    */

    $alreadyAssignedIds = BacklinkAssignment::where('seo_plan_client_id', $project->id)
        ->pluck('backlink_id');

    $toSync = Backlink::where('status', 'available')
        ->whereNotIn('id', $alreadyAssignedIds)
        ->get();

    if ($toSync->isNotEmpty()) {

        $rows = $toSync->map(function ($backlink) use ($project, $authUser) {
            return [
                'seo_plan_client_id' => $project->id,
                'backlink_id'        => $backlink->id,
                'assigned_to'        => null,
                'assigned_by'        => $authUser->id,
                'username'           => null,
                'password'           => null,
                'attachment'         => null,
                'remarks'            => null,
                'status'             => 'assigned',
                'assigned_at'        => now(),
                'completed_at'       => null,
                'completed_by'       => null,
                'created_at'         => now(),
                'updated_at'         => now(),
            ];
        })->toArray();

        BacklinkAssignment::insert($rows);
    }

    /*
    |--------------------------------------------------------------------------
    | Assigned Backlinks — oldest first, so newly synced ones stay at the
    | bottom automatically.
    |--------------------------------------------------------------------------
    */

    $assignedBacklinks = BacklinkAssignment::with([
        'backlink.category',
        'completedByUser',
    ])
    ->where('seo_plan_client_id', $project->id)
    ->oldest()
    ->get();

    /*
    |--------------------------------------------------------------------------
    | Categories for the filter dropdown
    |--------------------------------------------------------------------------
    */

    $categories = $assignedBacklinks
        ->pluck('backlink.category')
        ->filter()
        ->unique('id')
        ->values();

    /*
    |--------------------------------------------------------------------------
    | Cards
    |--------------------------------------------------------------------------
    */

    $totalBacklinks = Backlink::count();
    $availableCount = Backlink::where('status', 'available')->count();

    $assignedCount = BacklinkAssignment::where('seo_plan_client_id', $project->id)
        ->where('status', 'assigned')
        ->count();

    $completedCount = BacklinkAssignment::where('seo_plan_client_id', $project->id)
        ->where('status', 'completed')
        ->count();

    return view(
        'admin.backlink-assignment.index',
        compact(
            'project',
            'assignedBacklinks',
            'categories',
            'totalBacklinks',
            'availableCount',
            'assignedCount',
            'completedCount'
        )
    );
}







public function inlineUpdate(Request $request, $id)
{
    $assignment = BacklinkAssignment::with(['backlink', 'seoPlanClient.distributions'])->findOrFail($id);

    $authUser = auth()->user();
    $isAdmin = $authUser->role == 'admin';
    $distributionUserIds = $assignment->seoPlanClient->distributions->pluck('user_id')->unique();

    abort_unless($isAdmin || $distributionUserIds->contains($authUser->id), 403);

    $field = $request->input('field');
    $allowedFields = ['username', 'password', 'remarks', 'status', 'attachment'];

    if (!in_array($field, $allowedFields)) {
        return response()->json(['message' => 'Invalid field.'], 422);
    }

    switch ($field) {

        case 'username':
            $request->validate(['value' => 'required|string|max:255']);
            $assignment->username = $request->input('value');
            break;

        case 'password':
            $request->validate(['value' => 'required|string|max:255']);
            $assignment->password = $request->input('value');
            break;

        case 'remarks':
            $request->validate(['value' => 'nullable|string']);
            $assignment->remarks = $request->input('value');
            break;

        case 'status':
            $request->validate(['value' => 'required|in:assigned,completed']);

            $assignment->status = $request->input('value');

            if ($request->input('value') === 'completed') {
                $assignment->completed_at = Carbon::now();
                $assignment->completed_by = $authUser->id;
            } else {
                $assignment->completed_at = null;
                $assignment->completed_by = null;
            }

            break;

        case 'attachment':
            $request->validate([
                'attachment' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:5120',
            ]);

            // Purani file delete karo (agar public folder me thi)
            if ($assignment->attachment && file_exists(public_path($assignment->attachment))) {
                @unlink(public_path($assignment->attachment));
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();

            $destinationPath = public_path('uploads/backlinks');

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);

            // DB me relative path store karo (public/ ke andar se)
            $assignment->attachment = 'uploads/backlinks/' . $filename;

            break;
    }

    $assignment->save();
    $assignment->load('completedByUser');

    // return response()->json([
    //     'message'         => 'Updated successfully.',
    //     'field'           => $field,
    //     'status'          => $assignment->status,
    //     'completed_by'    => $assignment->completedByUser->name ?? null,
    //     'attachment_url'  => $assignment->attachment ? asset('storage/'.$assignment->attachment) : null,
    //     'attachment_name' => $assignment->attachment ? basename($assignment->attachment) : null,
    // ]);

    return response()->json([
        'message'         => 'Updated successfully.',
        'field'           => $field,
        'status'          => $assignment->status,
        'completed_by'    => $assignment->completedByUser->name ?? null,
        'attachment_url'  => $assignment->attachment ? asset($assignment->attachment) : null,
        'attachment_name' => $assignment->attachment ? basename($assignment->attachment) : null,
    ]);
}


    
}
