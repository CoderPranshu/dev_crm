<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{InstallController, ModalController};
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

require __DIR__.'/auth.php';


