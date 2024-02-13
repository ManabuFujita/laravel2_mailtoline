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
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;

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

Auth::routes([
    'confirm' => false, 
    'email' => false, 
    'reset' => false, 
    'register' => false, 
]);

Route::get('/', function () {
    return view('welcome');
})->name('top');


// ログインページ
Route::get('/login', function () {
    return auth()->user()
        ? redirect(route('home'))
        : view('auth/login');
})->name('loginPage');


// Lineログイン（認証チェックはcontrollerで実施）
Route::prefix('/login/line')->name('login.line.')->group(function() {
    Route::get('/redirect', [LoginController::class, 'redirectToLineProvider'])->name('redirect');
    Route::get('/callback', [LoginController::class, 'handleLineProviderCallback']);
});

// メール認証
Route::prefix('/login/google')->name('login.google.')->group(function() {
    Route::match(['get', 'post'], '/redirect', [LoginController::class, 'redirectToGoogleProvider'])->name('redirect');
    Route::match(['get', 'post'], '/callback', [LoginController::class, 'handleGoogleProviderCallback'])->name('callback');
});

// 利用規約等
Route::get('/page/{page}', [PageController::class, 'show'])
    ->name('page.view')
    ->missing(function (Request $request) {
        return redirect(route('top'));
    });

// 認証後
Route::middleware('auth')->group(function () {
    // ホーム
    Route::match(['get', 'post'], '/home', [HomeController::class, 'index'])->name('home');

    // メールフィルター設定
    Route::post('/mailfilter', [MailFilterController::class, 'button'])->name('mailfilter');
    Route::post('/mailfilter/delete', [MailFilterController::class, 'delete'])->name('mailfilter.delete');
});

// その他のルート
Route::fallback(function() {
    return redirect(route('top'));
});