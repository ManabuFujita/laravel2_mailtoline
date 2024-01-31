<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Mailfilter extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'line_id',
        'email',
        'mail_from',
        'subject',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
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

    public function getFilters($email) 
    {
        $line_id = auth()->user()->line_id;

        return $this
            ->where('line_id', $line_id)
            ->where('email', $email)
            ->orderBy('created_date', 'asc')
            ->get();
    }

    public function existsFilter($email, $mailFrom, $subject) 
    {
        $line_id = auth()->user()->line_id;

        return $this
            ->where('line_id', $line_id)
            ->where('email', $email)
            ->where('mail_from', $mailFrom ?? '')
            ->where('subject', $subject ?? '')
            ->first() != null;
    }

    public function setFilter($email, $mailFrom, $subject) 
    {
        $line_id = auth()->user()->line_id;

        return $this->create([
            'line_id' => $line_id,
            'email' => $email,
            'mail_from' => $mailFrom ?? '',
            'subject' => $subject ?? '',
        ]);
    }

    public function deleteFilter($email, $mailFrom, $subject) 
    {
        $line_id = auth()->user()->line_id;

        // dd([
        //     'line_id' => $line_id,
        //     'email' => $email,
        //     'mail_from' => $mailFrom,
        //     'subject' => $subject,
        // ]);

        return $this->where('line_id', $line_id)
            ->where('email', $email)
            ->where('mail_from', $mailFrom ?? '')
            ->where('subject', $subject ?? '')
            ->delete();
    }

}
