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

    public function test_top(): void
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
    }

    public function test_nothing(): void
    {
        $response = $this->get('/aaa');

        $response->assertRedirect(Route('top'));
    }



    // 利用規約等
    public function test_terms_of_service(): void
    {
        $response = $this->get('/page/terms-of-service');

        $response->assertOk();
        $response->assertSee('1. 利用規約の適用');
    }

    public function test_plivacy_policy(): void
    {
        $response = $this->get('/page/privacy-policy');

        $response->assertOk();
        $response->assertSee('1. 取得するユーザー情報と目的');
    }

    public function test_page_nothing(): void
    {
        $response = $this->get('/page/aaa');

        $response->assertRedirect(Route('top'));
    }

    // ログイン画面
    public function test_login(): void
    {
        $response = $this->get('/login');

        $response->assertOk();
        $response->assertSee('LINEでログインしてください');
    }

    // public function test_login_from_top(): void
    // {
    //     $this->browse(function (Browser $browser) {
    //         // トップページにアクセス
    //         $browser->visit('/')
    //                 // ログインボタンをクリック
    //                 ->click('@login-button')
    //                 // ログインページに遷移することを確認
    //                 ->assertPathIs('/login');
    //     });
    // }
}
