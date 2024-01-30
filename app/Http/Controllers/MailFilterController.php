<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Mailfilter;
use App\Models\Mail_gmail;
use DateTime;
use DateTimeImmutable;
use DateTimeInterface;
// use Google_Client;
// use Google_Service_Gmail;
use Google\Client;
use Google\Service\Gmail;
use SebastianBergmann\CodeUnit\FunctionUnit;
use Zoo;

class MailFilterController extends Controller
{
    protected $redirectToAfterLogin = '/home';

    /**
     * login
     */

    public function button(Request $request)
    {
        if ($request->has('register'))
        {
            $request->session()->put('button', 'register');
            $this->register($request);
        }

        if ($request->has('test'))
        {
            $request->session()->put('button', 'test');
            $this->test($request);
        }

        return back();
    }

    public function delete(Request $request)
    {
        $email = $request->email;
        $mailFrom = $request->mail_from;
        $subject = $request->subject;

        $mailfilter = new Mailfilter();
        $mailfilter->deleteFilter($email, $mailFrom, $subject);

        return redirect($this->redirectToAfterLogin);
    }

    private function register(Request $request)
    {
        $validator = $this->check($request);

        $email = $request->email;
        $mailFrom = $request->mail_from;
        $subject = $request->subject;

        $mailfilter = new Mailfilter();

        // echo $mailfilter->existsFilter($email, $mailFrom, $subject);

        if ($mailfilter->existsFilter($email, $mailFrom, $subject))
        {
            return back()   // 前の画面にリダイレクト
                ->withInput() // セッション(_old_input)に入力値すべてを入れる
                ->with('error', 'register_duplicate');
                // ->withErrors($validator); // セッション(errors)にエラーの情報を入れる
        }

        $mailfilter->setFilter($email, $mailFrom, $subject);

        return redirect($this->redirectToAfterLogin);
    }

    private function test(Request $request)
    {
        $validator = $this->check($request);


        if ($validator->fails()) { // バリデーションエラーがあるなら、
            // dd($validator);
            return back()   // 前の画面にリダイレクト
                ->withInput() // セッション(_old_input)に入力値すべてを入れる
                ->withErrors($validator); // セッション(errors)にエラーの情報を入れる
        }



        $email = $request->email;

        // dd($email);

        $gmail = new Mail_Gmail();
        // $token = $gmail->getToken($email);

        // 必要があれば処理を続ける
        $client = $gmail->getGmailClient($email);

        // 今日受信した対象メールを取得
        // $client = getClient();
        $service = new Gmail($client);

        $user = 'me';
        $optParams = [];

        // 日付取得
        // $dateFormatSendLog = 'Y/m/d';
        // $dateFormatCronLog = 'Y/m/d H:i:s';
        date_default_timezone_set('Asia/Tokyo');

        $dateStart = new DateTimeImmutable($request->term_start);
        $dateEnd = new DateTimeImmutable($request->term_end);

        // $todayYMD = date($dateFormatSendLog);
        // $yesterdayYMD = date($dateFormatSendLog, strtotime('-6 month'));
        // $tomorrowYMD = date($dateFormatSendLog, strtotime('+1 day'));


        $mailFrom = $request->mail_from;
        $subject = $request-> subject;

        // 昨日の対象メール数を取得
        $filter = 'to:'.$email;
        if ($mailFrom != null)
        {
            $filter .= ' from:' . $mailFrom;
        }
        if ($subject != null)
        {
            $filter .= ' subject:' . $subject . '';
        }
        $filter .= ' after:' . $dateStart->format('Y/m/d') . ' before:' . $dateEnd->format('Y/m/d');

        // dd($filter);

        $optParams['q'] = $filter;
        $filter_test_results = $service->users_messages->listUsersMessages($user, $optParams);
        $resultsCount = $filter_test_results['resultSizeEstimate'];

        $test = true;

        // dd($filter_test_results);

        // dd($resultsCount);

        // 抽出結果が50件を超える場合は、メール一覧を取得しない
        $filter_test_list = [];
        if (0 < $resultsCount && $resultsCount <= 50)
        {
            foreach($filter_test_results->getMessages() as $message)
            {
                // dd($m->id);
                $mail_id = $message->getId();
                $mail = $service->users_messages->get($user, $mail_id);

                // dd($mail);

                $headers = $mail->payload->headers;

                // dd($headers);

                // 結果からデータを抽出
                $subject_key = array_search('Subject', array_column($headers, 'name')); // ヘッダーオブジェクトの配列から件名オブジェクトの連番キーを取得
                $subject = $headers[$subject_key]->value; // 件名のオブジェクトからvalueプロパティの値を取得（件名の取得）

                $date_key = array_search('Date', array_column($headers, 'name'));
                $date = $headers[$date_key]->value;

                $from_key = array_search('From', array_column($headers, 'name'));
                $from = $headers[$from_key]->value;

                $to_key = array_search('To', array_column($headers, 'name'));
                $to = $headers[$to_key]->value;

                    // $date_str = "Fri, 26 Jan 2024 02:15:18 +0000 (UTC)";

                $date = preg_replace('/\s\(\w{3}\)/', '', $date); // " (UTC)"を除く

                    // $date_str = "Fri, 26 Jan 2024 02:15:18 +0000";
                    // dd([$date, 
                    //     DateTime::createFromFormat(DateTimeInterface::RFC2822, $date),
                    //     $headers,

                    //     DateTime::createFromFormat("D, d M Y H:i:s O", $date_str),
                    // ]);

                // 配列にセット
                array_push($filter_test_list, [
                    'subject' => $subject,
                    'date' => DateTime::createFromFormat(DateTimeInterface::RFC2822, $date)->format('Y/m/d H:i:s'),
                    'from' => $from,
                    'to' => $to,
                ]);
            }
        }

        // dd($filter_test_list);
        // dd($resultsCount);

        // return view('home', compact('filter_test_list'));
        return back()
            ->with('filterTestUser', $email)
            ->with('filterTest', $test)
            ->with('filterTestListCount', $resultsCount)
            ->with('filterTestList', $filter_test_list)
            ->withInput();
    }

    
    private function check(Request $request)
    {
        $request->session()->put('mail_from', $request->mail_from);
        $request->session()->put('subject', $request->subject);

        $rules = [
            'mail_from' => 'nullable|string|email:strict,dns|max:255',
            'subject' => 'nullable|string|max:255|required_if:mail_from,null',
        ];

        $validator = validator($request->all(), $rules); // バリデーションを実行

        return $validator;
    }

}
