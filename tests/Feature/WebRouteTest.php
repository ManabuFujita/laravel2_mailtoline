<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\User;

class WebRouteTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_setting(): void
    {
        // 環境変数の値を取得する
        $app_name = config('app.name');

        // 環境変数の値を検証する
        $this->assertEquals('mail to Line(testing)', $app_name);
    }

    // public function test_example(): void
    // {

    //     $response = $this->get('/welcome');

    //     // リクエストオブジェクトを取得する
    //     $request = $this->app['request'];
    //     // dd($request);

    //     // リクエストの完全なURLを取得する
    //     $fullUrl = $request->getUri();

    //     // リクエストの完全なURLを確認する
    //     // dd($fullUrl);



    //     // リダイレクト先のURLを確認する
    //     // dd($response->headers->all());

    //     // レスポンスの内容を確認する
    //     // dd($response->getOriginalContent());

    //     $response->assertStatus(200);
    //     // $response->assertSee('メールをLINEに自動転送するアプリ');
    // }

    public function test_root(): void
    {
        $response = $this->get('/');

        $response->assertOk();
        $response->assertViewIs('welcome');
        $response->assertSee('メールをLINEに自動転送するアプリ');
    }

    public function test_welcome(): void
    {
        $response = $this->get('/welcome');

        $response->assertRedirect(Route('top'));
        // $response->assertViewIs('welcome');
        // $response->assertSee('メールをLINEに自動転送するアプリ');
    }

    public function test_nothing(): void
    {
        $response = $this->get('/aaa');

        $response->assertRedirect(Route('top'));
    }
}
