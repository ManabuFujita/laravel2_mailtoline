<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Gmail extends Model
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
            $created_datetime = new Datetime($d['created']);
            $created = $created_datetime->getTimestamp();
        
            $token = array(
              'access_token' => $accessToken,
              'expires_in' => $expiresIn,
              'created' => $created,
              'refresh_token' => $refreshToken,
            );
        } else {
            $token = null;
        }


        return $token;
    }
}
