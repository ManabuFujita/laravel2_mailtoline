<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Gmail;

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


        // dd(Socialite::with('google')->user());

        $gmail = new Gmail;
        $gmail_list = $gmail->getData();
        
        // dd($gmail_list);

        $gmail_address = $gmail_list['email'];
        
        // $token = $gmail_list->token;


        require_once 'C:\xampp\htdocs\laravel2_mailtoline\vendor\autoload.php';

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

        $token = $gmail->getToken();

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


        // if (isset($_GET['code'])) {
        //     $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        //     dd($client->getAccessToken());
        // }


        // $httpClient = $client->authorize();
        // $response = $httpClient->get('https://www.googleapis.com/gmail/v1/users/me/messages?q=in:sent after:2023/01/01 before:2023/01/03');




        // dd($httpClient);
        // dd($response);



        // $service = new Google\Service\Gmail($client);
        // $user = 'me';
        // $messages = $service->users_messages->listUsersMessages($user);

        // // dd($messages);

        // $subjects = array();

        // foreach ($messages->getMessages() as $message) {
        //     $message_id = $message->getID();
        //     $message_contents = $service->users_messages->get($user, $message_id);

        //     // dd($message_contents);

        //     // ヘッダーの取得 
        //     $headers = $message_contents['payload']['headers']; // ヘッダーオブジェクトの配列 
        //     $subject_key = array_search('Subject', array_column($headers, 'name')); // ヘッダーオブジェクトの配列から件名オブジェクトの連番キーを取得 
        //     $subject = $headers[$subject_key]->value; // 件名のオブジェクトからvalueプロパティの値を取得（件名の取得）

        //     $url_safe_data = $message_contents['payload']['body']['data']; // 本文の取得 
        //     $data = str_replace(array('-', '_'), array('+', '/'), $url_safe_data); // // URL用のBase64エンコーディングされているため、文字置換 
        //     $decoded_data = base64_decode($data); // Base64デコードする

        //     array_push($subjects, $subject);
        // }

        // dd($subjects);







        // $token = $request->user()->access_token;
        // dd($token);

        // Google::setAccessToken($token);
        
        // $photos = Google::make('PhotosLibrary');
        
        // $albums = Photos::setService($photos)->listAlbums();




//         $client = new Google_Client();
// $client->setApplicationName('Gmail API PHP Quickstart');
// $client->setScopes(Google_Service_Gmail::GMAIL_READONLY);
// $client->setAuthConfig('credentials.json');
// $client->setAccessType('offline');
// $client->setPrompt('select_account consent');







        // if ($client->isAccessTokenExpired()) {
        //     // Refresh the token if possible, else fetch a new one.
        //     if ($client->getRefreshToken()) {
        //         $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
        //     } else {
        //        // request access of the user if it has not been granted.
        //     }
        //     // note after refresh remember to store the new refresh token.

        // } else {

        // }

        // $token = $client->getAccessToken();


        // dd($client);

        $line_id = auth()->user()->line_id;




        return view('home', compact('gmail_address', 'line_id', 'access_token', 'refresh_token', 'token_expired'));
    }
}
