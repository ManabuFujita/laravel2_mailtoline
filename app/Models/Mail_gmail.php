<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

use Google_Client;
use Google_Service_Gmail;

class Mail_gmail extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'line_id',
        'access_token',
        'refresh_token',
        'expires_in',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getAllData() 
    {
        $line_id = auth()->user()->line_id;

        return $this->where('line_id', $line_id)->get();
    }

    public function getData($email) 
    {
        $line_id = auth()->user()->line_id;

        return $this->where('line_id', $line_id)->where('email', $email)->first();
    }

    public function getToken($email)
    {
        $d = $this->getData($email);

        if ($d != null)
        {
            $lineId = $d['line_id'];
            $accessToken = $d['access_token']; 
            $refreshToken = $d['refresh_token'];
            $idToken = $d['id_token'];
            $expiresIn = $d['expires_in'];
            // $created_datetime = new Datetime($l['created']);
            // $created = $created_datetime->getTimestamp();
            if ($d['created'] != null)
            {
                $created = $this->datetimeFormat2timestamp($d['created']);
            } else {
                $created = null;
            }

        
            $token = array(
              'access_token' => $accessToken,
              'expires_in' => $expiresIn,
              'created' => $created,
              'refresh_token' => $refreshToken,
              'id_token' => $idToken,
            );


            // dd($token);
        } else {
            $token = null;
        }

        return $token;
    }

    public function getGmailClient($email)
    {
        $token = $this->getToken($email);
        $client = $this->newGmailClient();

        try {
            $client->setAccessToken($token);

            if ($client->isAccessTokenExpired()) {
                if ($client->getRefreshToken()) {
                    $newToken = $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());

                    if (array_key_exists('error', $newToken)) {
                        // トークン無効→DBから削除してhomeへ
                        throw new \Exception('invalid_grant'); // 削除処理はしない、例外を投げるだけ
                    }
                }
            }
        } catch (\Google\Service\Exception $e) {
            // Google APIエラー→DBから削除してhomeへ
            $this->where('line_id', auth()->user()->line_id)
                ->where('email', $email)
                ->delete();
            return redirect('/home')->with('error', 'Googleアカウントでエラーが発生しました。再度連携してください。');
        }
        
        return $client;
    }

    public function newGmailClient()
    {
        $client = new Google_Client();
        $client->setApplicationName('Gmail API PHP Quickstart');
        $client->setScopes(Google_Service_Gmail::GMAIL_READONLY);
        // $client->setAuthConfig('credentials.json');
        $client->setAuthConfig(base_path('credentials.json'));
        $client->setAccessType('offline');
        $client->setPrompt('select_account consent');

        return $client;
    }

    public function updateToken($lineId, $email, $accessToken, $refreshToken, $idToken, $expiresIn, $created)
    {
        $this->where('line_id', $lineId)
            ->where('email', $email)
            ->update([
                'access_token' => $accessToken,
                'refresh_token' => $refreshToken,
                'id_token' => $idToken,
                'expires_in' => $expiresIn,
                'created' => $created,
            ]);
    }

    public function revokeToken($email)
    {
        $this->where('line_id', auth()->user()->line_id)
            ->where('email', $email)
            ->delete();
    }

    private function datetimeFormat2timestamp($datetime_format)
    {
        $datetime = new Datetime($datetime_format);
        return $this->datetime2timestamp($datetime);
    }

    private function datetime2timestamp($datetime)
    {
        return $datetime->getTimestamp();
    }

    public function timestamp2datetime($timestamp)
    {
        return date('Y-m-d H:i:s', $timestamp);
    }
}
