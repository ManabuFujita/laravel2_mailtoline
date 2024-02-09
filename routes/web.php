<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// use App\Http\Controllers\TodoListController;
use App\Http\Controllers\Test1Controller;
use App\Http\Controllers\LineLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MailFilterController;
use App\Http\Controllers\PageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Auth::routes();

Route::get('/build/{any}', function ($any) {
    $extensions = substr($any, strrpos($any, '.') + 1);
    $mine_type=[
        "css"=>"text/css",
        "js"=>"application/javascript"
    ];
    if(!array_key_exists($extensions,$mine_type)){
        return \App::abort(404);
    }
    if(!file_exists(public_path() . '/build/'.$any)){
        return \App::abort(404);
    }
    return response(\File::get(public_path() . '/build/'.$any))->header('Content-Type',$mine_type[$extensions]);
})->where('any', '.*');



Route::get('/', function () {
    return view('welcome');
})->name('top');


Route::prefix('login')->name('login.')->group(function() {
    Route::get('/line/redirect', [LoginController::class, 'redirectToLineProvider'])->name('line');
    Route::get('/line/callback', [LoginController::class, 'handleLineProviderCallback']);
    
    Route::match(['get, post'], '/google/redirect', [LoginController::class, 'redirectToGoogleProvider'])
            ->name('google.redirect');
    Route::match(['get, post'], '/google/callback', [LoginController::class, 'handleGoogleProviderCallback'])
            ->name('google.callback');
});

Route::match(['get, post'], '/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');


Route::get('/page/{page}', [PageController::class, 'show'])
    ->name('page.view')
    ->missing(function (Request $request) {
        return redirect('/');
    });




// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::post('/mailfilter', [MailFilterController::class, 'button'])->name('mailfilter');
Route::post('/mailfilter/delete', [MailFilterController::class, 'delete'])->name('mailfilter.delete');


// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

// require __DIR__.'/auth.php';




Route::fallback(function() {
    // return view('route.error');
    return redirect('/');
});