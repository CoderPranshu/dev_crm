<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SupportController;


use App\Http\Controllers\Api\AttendanceApiController;
use App\Http\Controllers\Api\LeadApiController;

use App\Http\Controllers\Admin\LeadController as AdminLeadController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/supports', [SupportController::class, 'index']);
    Route::post('/supports', [SupportController::class, 'store']);
    Route::get('/supports/{id}', [SupportController::class, 'show'])->whereNumber('id');
    Route::post('/support/reply', [SupportController::class, 'reply'])->name('api.support.reply');

    // Employee attendance
    Route::get(
        '/attendance/today',
        [AttendanceApiController::class, 'today']
    );

    // Route::get(
    // '/admin/attendance',
    // [AttendanceApiController::class, 'adminAttendance']
    // );
    
    // whole

    Route::get(
        '/employee/attendance',
        [AttendanceApiController::class, 'employeeAttendance']
    );

    Route::get(
        '/admin/attendance',
        [AttendanceApiController::class, 'adminAttendance']
    ); 

});

Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('permission:lead-list')->get(
        '/leads',
        [LeadApiController::class, 'index']
    );

    // ── Static options (must be before {id} routes) ──────────────────────────
    Route::get('/lead-action-options', [LeadApiController::class, 'actionOptions']);
    Route::get('/branches', [LeadApiController::class, 'branches']);
    Route::get('/sales-users', [LeadApiController::class, 'salesUsers']);

    // ── Named sub-paths (must be before {id}) ────────────────────────────────
    Route::middleware('permission:lead-list')->get(
        '/leads/stats',
        [LeadApiController::class, 'stats']
    );

    Route::middleware('permission:lead-list')->get(
        '/leads/follow-ups',
        [LeadApiController::class, 'followUps']
    );

    Route::middleware('permission:lead-list')->get(
        '/leads/rejected',
        [LeadApiController::class, 'rejected']
    );

    Route::middleware('permission:lead-list')->get(
        '/leads/today-meetings',
        [LeadApiController::class, 'todayMeetings']
    );

    Route::middleware('permission:lead-list')->get(
        '/leads/pipeline',
        [LeadApiController::class, 'pipeline']
    );

    Route::middleware('permission:lead-list')->get(
        '/lead-actions',
        [LeadApiController::class, 'allActions']
    );

    Route::middleware('permission:lead-list')->get(
        '/leads/{id}',
        [LeadApiController::class, 'show']
    )->whereNumber('id');

    Route::middleware('permission:lead-create')
    ->post('/leads', [LeadApiController::class, 'store']);
    
    Route::middleware('permission:lead-update')
    ->put('/leads/{id}', [LeadApiController::class, 'update']
    )->whereNumber('id');

    Route::get('/lead-categories', [
        LeadApiController::class,
        'categories'
    ])->middleware('permission:lead-create');

    Route::middleware('permission:lead-list')->get(
    '/leads/{id}/actions',
    [LeadApiController::class, 'actions']
    )->whereNumber('id');

    // Lead Notes
    Route::middleware('permission:lead-list')->get(
        '/leads/{id}/notes',
        [LeadApiController::class, 'getNotes']
    )->whereNumber('id');

    Route::middleware('permission:lead-update')->post(
        '/leads/{id}/notes',
        [LeadApiController::class, 'storeNote']
    )->whereNumber('id');

    // Lead Transfers History
    Route::middleware('permission:lead-list')->get(
        '/leads/{id}/transfers',
        [LeadApiController::class, 'transfers']
    )->whereNumber('id');



    // Lead Actions API
    Route::middleware('permission:lead-update')->group(function () {
        Route::post(
            '/leads/{id}/contacted',
            [AdminLeadController::class, 'markContacted']
        )->whereNumber('id');

        Route::post(
            '/leads/{id}/actions',
            [AdminLeadController::class, 'storeLeadAction']
        )->whereNumber('id');

        Route::post(
            '/leads/{id}/follow-up',
            [AdminLeadController::class, 'storeFollowUp']
        )->whereNumber('id');

        Route::patch(
            '/lead-actions/{id}',
            [AdminLeadController::class, 'updateLeadActionType']
        )->whereNumber('id');

        Route::post(
            '/leads/{id}/transfer',
            [AdminLeadController::class, 'transfer']
        )->whereNumber('id');

    });


    Route::get('/quotation-categories', [
    LeadApiController::class,
    'quotationCategories'
    ])->middleware('permission:lead-list');

    Route::middleware('permission:lead-list')->get(
    '/detailed-quotations',
    [LeadApiController::class, 'detailedQuotations']
    );

    Route::middleware('permission:lead-list')->get(
        '/detailed-proposals',
        [LeadApiController::class, 'detailedQuotations']
    );

    Route::middleware('permission:lead-update')->post(
        '/leads/{id}/detailed-quotation',
        [LeadApiController::class, 'sendDetailedQuotation']
    )->whereNumber('id');

    // Route::middleware('permission:lead-update')->post(
    //     '/leads/{id}/detailed-proposal',
    //     [LeadApiController::class, 'sendDetailedQuotation']
    // )->whereNumber('id');

    Route::middleware('permission:lead-update')->post(
        '/leads/{id}/detailed-proposal',
        [LeadApiController::class, 'sendDetailedQuotation']
    )->whereNumber('id');
});


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::delete('/logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);
});

Route::post('/attendance/punches', function (Request $request) {
    $token = config('services.attendance.sync_token');

    if (
        !is_string($token) ||
        $token === '' ||
        !hash_equals($token, (string) $request->bearerToken())
    ) {
        abort(401);
    }

    $data = $request->validate([
        'records' => ['required', 'array', 'min:1', 'max:100'],
        'records.*.device_id' => ['required', 'string', 'max:30'],
        'records.*.employee_no' => ['required', 'string', 'max:40'],
        'records.*.punch_at' => ['required', 'date_format:Y-m-d H:i:s'],
        'records.*.verify_mode' => ['required', 'integer', 'min:0'],
    ]);

    $now = now();

    $rows = array_map(
        static fn (array $record) => $record + [
            'created_at' => $now,
            'updated_at' => $now,
        ],
        $data['records']
    );

    DB::table('biometric_punches')->upsert(
        $rows,
        ['device_id', 'employee_no', 'punch_at', 'verify_mode'],
        ['updated_at']
    );

    return response()->json([
        'accepted' => count($rows),
    ]);
});