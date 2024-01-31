<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Mail_gmail;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

use Google_Client;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('guest')->except('logout');
    }

    // Line

    /**
     * 外部サービスの認証ページへリダイレクトする。
     */
    public function redirectToLineProvider()
    {
        if (Auth::check()) { // ログイン済みならトップに飛ばす
            return redirect('/home');
        }

        return Socialite::driver('line')->redirect();
    }

    /**
     * 外部サービスからユーザー情報を取得し、ログインする。
     */
    public function handleLineProviderCallback(Request $request)
    {
        if (Auth::check()) { // ログイン済みならトップに飛ばす
            return redirect('/home');
        }

        $line_user = Socialite::driver('line')->stateless()->user();

        $user = User::firstOrCreate(
            ['line_id' => $line_user->id],
            ['name' => $line_user->name]
        );

        $this->guard()->login($user, true);
        return $this->sendLoginResponse($request);
    }

    // private function checkAuth(Request $request)
    // {
    //     // 認証済みならhomeへ遷移
    //     // $this->middleware('guest')->except('logout');

    //     // dd(Auth::check());

    //     if (Auth::check()) { // ログイン済みならトップに飛ばす
    //         return redirect('/home');
    //     }
    // }

    // Google
    public function redirectToGoogleProvider()
    {
        return Socialite::driver('google')
                ->with(["access_type" => "offline", "prompt" => "consent select_account"])
                ->scopes(["https://www.googleapis.com/auth/gmail.readonly"])
                ->redirect();
    }

    public function handleGoogleProviderCallback(Request $request)
    {
        $line_user = auth()->user();

        // dd($line_user);

        // dd($_COOKIE['g_csrf_token']);
        // dd($request->input('g_csrf_token'));

        // if ($_COOKIE['g_csrf_token'] !== $request->input('g_csrf_token')) {
        //     // Invalid CSRF token
        //     return back();
        // }

        // $idToken = $request->input('credential'); 

        // $client = new Google_Client([
        //     'client_id' => env('GOOGLE_CLIENT_ID')
        // ]);
        
        // $payload = $client->verifyIdToken($idToken);
        
        // if (!$payload) {
        //     // Invalid ID token
        //     return back();
        // }


        // dd($client->authorize());
        
        // dd($payload);


        // dd($request);
        
        $google_user = Socialite::driver('google')->stateless()->user();
        // $google_user = Socialite::driver('google')->user();


        $user = Mail_gmail::updateOrCreate(
            ['line_id' => $line_user->line_id, 
            'email' => $google_user->email],
            ['name' => $google_user->name,
            'access_token' => $google_user->token,
            'refresh_token' => $google_user->refreshToken,
            'expires_in' => $google_user->expiresIn,
            ],
        );

        // $this->guard()->login($user, true);
        return $this->sendLoginResponse($request);
    }
}