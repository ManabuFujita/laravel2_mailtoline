<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Mail_gmail;
use App\Models\Mailfilter;

use Google;
use Google_Client;
use Google_Service_Drive;
use Google_Service_Gmail;
use Google_Service_Calendar_Channel;
use Google_Service_Exception;
use Google_Auth;
use Laravel\Socialite\Facades\Socialite;

use function PHPUnit\Framework\isEmpty;

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



        $lineId = auth()->user()->line_id;

        $access_token = '';
        $refresh_token = '';
        $token_expired = false;
        $filterList = [];

        // dd(Socialite::with('google')->user());

        $gmail = new Mail_Gmail;
        $gmailList = $gmail->getAllData();
        
        // dd($gmail_list);

        if ($gmailList == null)
        {
            $gmail_address = '';
        } else {
            foreach ($gmailList as $list)
            {
                $gmail_address = $list['email'];


                $token = $gmail->getToken($gmail_address);


                // $client = new Google_Client();
                // $client->setAuthConfig('C:\xampp\htdocs\laravel2_mailtoline\credentials.json');

                // $client->addScope(Google_Service_Drive::DRIVE_METADATA_READONLY);
                // $client->setScopes(Google_Service_Gmail::GMAIL_READONLY);

                $gmail = new Mail_Gmail;
                $client = $gmail->newGmailClient();


        

        
                // $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/home';
                // $client->setRedirectUri($redirect_uri);
        
         
    

                // $gmail = new Mail_gmail();
                // $client = $gmail->newGmailClient();





                // dd($token);
        
                if ($token != null)
                {
                    $client->setAccessToken($token);
        
                    $access_token = $token['access_token'];
                    $refresh_token = $token['refresh_token'];
        
                    $token_expired = $client->isAccessTokenExpired(); // うまくできてない
                    
                    // トークン更新
                    if ($token_expired)
                    {
                        // dd($token);
                        $client->fetchAccessTokenWithRefreshToken($token['refresh_token']);

                        $token = $client->getAccessToken();

                        // dd($token);

                        $accessToken = $token['access_token'];
                        $refreshToken = $token['refresh_token'];
                        $idToken = $token['id_token'];
                        $expiresIn = $token['expires_in'];
                        if ($token['created'] != null)
                        {
                            $created = $gmail->timestamp2datetime($token['created']);
                        } else {
                            $created = null;
                        }


                        $gmail->updateToken($lineId, $gmail_address, $accessToken, $refreshToken, $idToken, $expiresIn, $created);

                        // トークン更新後チェック
                        $token = $gmail->getToken($gmail_address);
                        $client->setAccessToken($token);

                        $token_expired = $client->isAccessTokenExpired();
                    }
                    // dd($token_expired);

                } else {
                    $access_token = '';
                    $refresh_token = '';
        
                    $token_expired = false;
                }

                

                // filter設定取得
                $mailFilter = new Mailfilter();

                $filter = $mailFilter->getFilters($gmail_address);

                if ($filter->isNotEmpty())
                {
                    $filterArray = array($gmail_address =>$filter);

                    if (!isset($filterList))
                    {
                        $filterList = array($gmail_address => $mailFilter->getFilters($gmail_address));
                    } else {
                        // dd($filterList);
                        $filterList += array($gmail_address => $mailFilter->getFilters($gmail_address));
                        // dd(array($gmail_address => $mailFilter->getFilters($gmail_address)));
                    }
                }



                // $filterList = $mailFilter->getFilters($gmail_address);



            }
            
        }
        
        // dd($filterList);
        // $token = $gmail_list->token;

        return view('home', compact('gmailList', 'access_token', 'refresh_token', 'token_expired', 'filterList'));
    }
}
