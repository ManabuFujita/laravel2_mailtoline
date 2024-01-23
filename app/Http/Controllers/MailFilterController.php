<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mailfilter;

class MailFilterController extends Controller
{
    protected $redirectToAfterLogin = '/home';

    /**
     * login
     */
    public function check(Request $request)
    {
        $rules = [
            'mail_from' => 'string|email:strict,dns|max:255',
            'title' => 'string|max:3',
        ];


        $validator = validator($request->all(), $rules); // バリデーションを実行
 
        if ($validator->fails()) { // バリデーションエラーがあるなら、
            return back()   // 前の画面にリダイレクト
                ->withInput() // セッション(_old_input)に入力値すべてを入れる
                ->withErrors($validator); // セッション(errors)にエラーの情報を入れる
        }




        // $validator = $request->validate([       // <-- ここがバリデーション部分
        //     'mail_from' => 'required|string|email:strict,dns|max:255',
        // ]);
        // $user = User::where('email', $request->email)->first();
        // Auth::login($user);

        // dd($request);

        $email = $request->email;
        $mailFrom = $request->mail_from;

        $mailfilter = new Mailfilter();

        if ($mailfilter->existsFilter($email, $mailFrom))
        {
            return back()   // 前の画面にリダイレクト
                ->withInput() // セッション(_old_input)に入力値すべてを入れる
                ->withErrors($validator); // セッション(errors)にエラーの情報を入れる
        }

        // $mailfilter->setFilterMailFrom($email, $mailFrom);

        return redirect($this->redirectToAfterLogin);
    }
}
