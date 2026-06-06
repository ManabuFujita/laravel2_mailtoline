<?php

namespace App\Services;

use App\Models\Mail_gmail;

class GmailService
{
    const AUTH_ERROR_MESSAGE = 'Googleアカウントの認証が切れました。再度連携してください。';

    public function handleAuthError($email)
    {
        $this->revokeToken($email);
        return redirect('/home')->with('error', self::AUTH_ERROR_MESSAGE);
    }

    public function revokeToken($email)
    {
        $gmail = new Mail_gmail();
        $gmail->where('line_id', auth()->user()->line_id)
            ->where('email', $email)
            ->delete();
    }
}

