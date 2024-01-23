<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Gmail;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

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
        $this->checkAuth();

        return Socialite::driver('line')->redirect();
    }

    /**
     * 外部サービスからユーザー情報を取得し、ログインする。
     */
    public function handleLineProviderCallback(Request $request)
    {
        $this->checkAuth();

        $line_user = Socialite::driver('line')->user();

        $user = User::firstOrCreate(
            ['line_id' => $line_user->id],
            ['name' => $line_user->name]
        );

        $this->guard()->login($user, true);
        return $this->sendLoginResponse($request);
    }

    private function checkAuth()
    {
        // 認証済みならhomeへ遷移
        $this->middleware('guest')->except('logout');
    }

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
        
        $google_user = Socialite::driver('google')->stateless()->user();
        // $google_user = Socialite::driver('google')->user();

        // dd($google_user);

        // dd($request);

        // dd($google_user->token);



        $user = Gmail::updateOrCreate(
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