<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\SupportController;

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
});

Route::post('/login', [AuthController::class, 'login']);

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