<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// use App\Http\Controllers\TodoListController;
use App\Http\Controllers\Test1Controller;
use App\Http\Controllers\LineLoginController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\MailFilterController;

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

Route::prefix('login')->name('login.')->group(function() {
    Route::get('/line/redirect', [LoginController::class, 'redirectToLineProvider'])->name('line.redirect');
    Route::get('/line/callback', [LoginController::class, 'handleLineProviderCallback'])->name('line.callback');
    Route::get('/google/redirect', [LoginController::class, 'redirectToGoogleProvider'])->name('google.redirect');
    Route::get('/google/callback', [LoginController::class, 'handleGoogleProviderCallback'])->name('google.callback');
});

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/', function () {
    return redirect('login/line/redirect');
    // return view('line.redirec');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Line
// Route::get('/linelogin', [LineLoginController::class, 'lineLogin'])->name('linelogin');
// Route::get('/callback', [LineLoginController::class, 'callback'])->name('callback');

Route::post('/mailfilter', [MailFilterController::class, 'check'])->name('mailfilter');


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
    return view('route.error');
});