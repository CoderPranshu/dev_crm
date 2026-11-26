<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{InstallController, ModalController};

use App\Http\Controllers\AiChatController;

use App\Http\Controllers\MusicPermissionController;


// use Auth;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
use Illuminate\Routing\Router;
//Cache clearing route
Route::get('/clear-cache', function (Router $route) {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    return 'Application cache cleared';
});

//Root route
Route::get('/', function () {

	// if(auth()->user()->role == 'admin'){
		return redirect(route('admin.dashboard'));
	// }elseif(auth()->user()->role == 'staff'){
	// 	return redirect(route('staff.dashboard'));
	// }
    return view('auth/login');
})->middleware(['auth', 'verified'])->name('root');

//Logout route
Route::get('/logout', function () {
	Auth::logout();
	return redirect(route('login'));
})->name('logout');

//Modal controllers group routing
Route::controller(ModalController::class)->group(function () {
    Route::any('/right-modal/{view_path}', 'right_modal')
        ->where('view_path', '.*')
        ->name('right_modal');
});

Route::controller(ModalController::class)->group(function () {
    Route::any('/center-modal/{view_path}', 'center_modal')
        ->where('view_path', '.*')
        ->name('center_modal');
});



Route::get('/phpinfo-test', function () {
    phpinfo();
});


Route::middleware(['auth'])->prefix('ai-chat')->name('ai-chat.')->group(function () {
    Route::get('/', [AiChatController::class, 'index'])->name('index');
    Route::post('/send', [AiChatController::class, 'send'])->name('send');
});

// Add this block OUTSIDE an admin-only group. All logged-in staff need access.
Route::middleware('auth')->prefix('music-permission')->name('music.')->group(function () {
    Route::get('/', [MusicPermissionController::class, 'index'])->name('index');
    Route::post('/requests', [MusicPermissionController::class, 'request'])->name('requests.store');
    Route::post('/requests/{id}/vote', [MusicPermissionController::class, 'vote'])->whereNumber('id')->name('requests.vote');
    Route::post('/requests/{id}/override', [MusicPermissionController::class, 'override'])->whereNumber('id')->name('requests.override');
    Route::post('/requests/{id}/start', [MusicPermissionController::class, 'start'])->whereNumber('id')->name('requests.start');
    Route::post('/requests/{id}/stop', [MusicPermissionController::class, 'stop'])->whereNumber('id')->name('requests.stop');
    Route::post('/complaints', [MusicPermissionController::class, 'complain'])->name('complaints.store');
    Route::post('/complaints/{id}/review', [MusicPermissionController::class, 'reviewComplaint'])->whereNumber('id')->name('complaints.review');
    Route::post('/proposals/{id}/response', [MusicPermissionController::class, 'respond'])->whereNumber('id')->name('proposals.respond');
    Route::post('/proposals/{id}/decision', [MusicPermissionController::class, 'decideProposal'])->whereNumber('id')->name('proposals.decide');
});




require __DIR__.'/auth.php';


