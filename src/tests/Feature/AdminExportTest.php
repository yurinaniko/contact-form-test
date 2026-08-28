<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 管理画面のCSV出力。
 *
 * 全件の氏名・メール・電話番号・住所が出る経路なので、
 * 「誰が叩けるか」と「何が出るか」の両方を固定する。
 */
class AdminExportTest extends TestCase
{
    use RefreshDatabase;

    private function 問い合わせを用意(): array
    {
        $category = Category::forceCreate(['content' => '商品の交換について']);

        $taro = Contact::forceCreate([
            'category_id' => $category->id,
            'last_name' => '山田', 'first_name' => '太郎',
            'gender' => 1, 'email' => 'taro@example.com',
            'tel' => '080-1234-5678', 'address' => '東京都渋谷区',
            'building' => null, 'detail' => '交換希望です',
        ]);

        $hanako = Contact::forceCreate([
            'category_id' => $category->id,
            'last_name' => '鈴木', 'first_name' => '花子',
            'gender' => 2, 'email' => 'hanako@example.com',
            'tel' => '090-9876-5432', 'address' => '大阪府大阪市',
            'building' => null, 'detail' => '返品希望です',
        ]);

        return [$taro, $hanako];
    }

    /** @test */
    public function 未ログインではCSVをダウンロードできない()
    {
        $this->get('/admin/export')->assertRedirect('/login');
    }

    /** @test */
    public function 未ログインでは管理画面の一覧と検索を開けない()
    {
        $this->get('/admin')->assertRedirect('/login');
        $this->get('/admin/search')->assertRedirect('/login');
    }

    /** @test */
    public function 検索で絞り込んだ結果だけがCSVに出力される()
    {
        $this->問い合わせを用意();

        $csv = $this->actingAs(User::factory()->create())
            ->get('/admin/export?keyword=山田')
            ->streamedContent();

        $this->assertStringContainsString('山田 太郎', $csv);
        $this->assertStringNotContainsString('鈴木 花子', $csv);
    }

    /** @test */
    public function 条件を指定しなければ全件がCSVに出力される()
    {
        $this->問い合わせを用意();

        $csv = $this->actingAs(User::factory()->create())
            ->get('/admin/export')
            ->streamedContent();

        $this->assertStringContainsString('山田 太郎', $csv);
        $this->assertStringContainsString('鈴木 花子', $csv);
    }

    /** @test */
    public function CSVの先頭にBOMが付いていて文字化けしない()
    {
        $this->問い合わせを用意();

        $csv = $this->actingAs(User::factory()->create())
            ->get('/admin/export')
            ->streamedContent();

        // ExcelがUTF-8と認識するための目印
        $this->assertStringStartsWith("\xEF\xBB\xBF", $csv);
        $this->assertStringContainsString('お問い合わせ種類', $csv);
    }

    /** @test */
    public function 検索結果の2ページ目にも検索条件が引き継がれる()
    {
        $this->問い合わせを用意();

        $this->actingAs(User::factory()->create())
            ->get('/admin/search?keyword=山田')
            ->assertOk()
            ->assertSee('keyword=%E5%B1%B1%E7%94%B0', false);
    }

    /** @test */
    public function CSVインジェクションになる値はクォートで無害化される()
    {
        $category = Category::forceCreate(['content' => '商品の交換について']);
        Contact::forceCreate([
            'category_id' => $category->id,
            'last_name' => '=1+1', 'first_name' => '太郎',
            'gender' => 1, 'email' => 'evil@example.com',
            'tel' => '080-0000-0000', 'address' => '東京都',
            'building' => null, 'detail' => '@SUM(A1:A2)',
        ]);

        $csv = $this->actingAs(User::factory()->create())
            ->get('/admin/export')
            ->streamedContent();

        // 数式として実行されうるセルは先頭にシングルクォートが付く
        $this->assertStringContainsString("'=1+1", $csv);
        $this->assertStringContainsString("'@SUM(A1:A2)", $csv);
        // 生の "=1+1" 始まりのセルは存在しない
        $this->assertStringNotContainsString(',=1+1', $csv);
    }
}
