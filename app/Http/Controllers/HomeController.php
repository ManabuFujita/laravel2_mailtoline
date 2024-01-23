<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gmail;
use App\Models\Mailfilter;

use Google;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Gmail;
use Google_Service_Calendar_Channel;
use Google_Service_Exception;
use Google_Auth;
use Laravel\Socialite\Facades\Socialite;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {

        require_once 'C:\xampp\htdocs\laravel2_mailtoline\vendor\autoload.php';



        $line_id = auth()->user()->line_id;

        $access_token = '';
        $refresh_token = '';
        $token_expired = false;
        $filters = [];

        // dd(Socialite::with('google')->user());

        $gmail = new Gmail;
        $gmail_list = $gmail->getAllData();
        
        // dd($gmail_list);

        if ($gmail_list == null)
        {
            $gmail_address = '';
        } else {
            foreach ($gmail_list as $list)
            {
                $gmail_address = $list['email'];


                $client = new Google_Client();
                $client->setAuthConfig('C:\xampp\htdocs\laravel2_mailtoline\credentials.json');
        
                // $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
                $client->setScopes(Google_Service_Gmail::GMAIL_READONLY);
        
                $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/home';
                $client->setRedirectUri($redirect_uri);
        
         
        
        
                $client = new Google_Client();
                $client->setApplicationName('Gmail API PHP Quickstart');
                $client->setScopes(Google_Service_Gmail::GMAIL_READONLY);
                // $client->setAuthConfig('credentials.json');
                $client->setAuthConfig('C:\xampp\htdocs\laravel2_mailtoline\credentials.json');
                $client->setAccessType('offline');
                $client->setPrompt('select_account consent');

                $token = $gmail->getToken($gmail_address);

                // dd($token);
        
                if ($token != null)
                {
                    $client->setAccessToken($token);
        
                    $access_token = $token['access_token'];
                    $refresh_token = $token['refresh_token'];
        
                    $token_expired = $client->isAccessTokenExpired();
                } else {
                    $access_token = '';
                    $refresh_token = '';
        
                    $token_expired = false;
                }

                

                // filter設定
                $mail_filter = new Mailfilter();
                $filters = $mail_filter->getFilters($gmail_address);

            }
            
        }
        
        // $token = $gmail_list->token;








        return view('home', compact('gmail_list', 'access_token', 'refresh_token', 'token_expired', 'filters'));
    }
}
