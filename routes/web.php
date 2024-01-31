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

Auth::routes();

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




// Route::get('login/line/redirect', [LoginController::class, 'redirectToLineProvider'])->name('line.login');




Route::prefix('login')->name('login.')->group(function() {
    Route::get('/line/redirect', [LoginController::class, 'redirectToLineProvider'])->name('line');
    Route::get('/line/callback', [LoginController::class, 'handleLineProviderCallback']);
    
    Route::get('/google/redirect', [LoginController::class, 'redirectToGoogleProvider'])->name('google.redirect');
    Route::post('/google/redirect', [LoginController::class, 'redirectToGoogleProvider'])->name('google.redirect');
    Route::get('/google/callback', [LoginController::class, 'handleGoogleProviderCallback'])->name('google.callback');
    Route::post('/google/callback', [LoginController::class, 'handleGoogleProviderCallback'])->name('google.callback');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
Route::post('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');


// Route::get('/register', function () {
//     return redirect('login/line/redirect');
// });

// Route::get('/welcome', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::resource('page', PageController::class, ['only' => [
//     'index', 'show'
// ]]);

Route::get('page/{page}', [PageController::class, 'show'])
    ->name('page.view')
    ->missing(function (Request $request) {
        return redirect('/');
    });



Route::get('/', function () {
    return view('welcome');

    // return redirect('login/line/redirect');
})->name('top');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Line
// Route::get('/linelogin', [LineLoginController::class, 'lineLogin'])->name('linelogin');
// Route::get('/callback', [LineLoginController::class, 'callback'])->name('callback');

Route::post('/mailfilter', [MailFilterController::class, 'button'])->name('mailfilter');
Route::post('/mailfilter/delete', [MailFilterController::class, 'delete'])->name('mailfilter.delete');

// Route::get('/list', [TodoListController::class, 'index']);

// Route::get('/test1', [Test1Controller::class, 'index']);
Route::get('/test1', [Test1Controller::class, 'index2'])->name('root');
Route::get('/test1/callback', [Test1Controller::class, 'login'])->name('callback');



// Route::get('/test1/getTemp', [Test1Controller::class, 'getTemp'])->name('temperature');
// Route::get('/test1/getRain', [Test1Controller::class, 'getRain'])->name('rain');
// Route::get('/test1/getWeatherChart', [Test1Controller::class, 'getWeatherChart'])->name('weatherChart');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// require __DIR__.'/auth.php';

Route::fallback(function() {
    // return view('route.error');
    return redirect('/');
});