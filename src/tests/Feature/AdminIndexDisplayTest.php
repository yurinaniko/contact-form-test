<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * 管理画面の表示内容。
 *
 * 詳細モーダルの電話番号が $contact->tell（存在しない属性）を参照して
 * 常に空欄になっていたバグの再発防止と、検索フォームの入力値保持を固定する。
 */
class AdminIndexDisplayTest extends TestCase
{
    use RefreshDatabase;

    private function 問い合わせを用意(): Contact
    {
        $category = Category::forceCreate(['content' => '商品の交換について']);

        return Contact::forceCreate([
            'category_id' => $category->id,
            'last_name' => '山田', 'first_name' => '太郎',
            'gender' => 1, 'email' => 'taro@example.com',
            'tel' => '080-1234-5678', 'address' => '東京都渋谷区',
            'building' => null, 'detail' => '交換希望です',
        ]);
    }

    /** @test */
    public function 詳細モーダルに電話番号が表示される()
    {
        $contact = $this->問い合わせを用意();
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin');

        $response->assertStatus(200);
        $response->assertSee('080-1234-5678');
    }

    /** @test */
    public function 検索後もフォームにキーワードが保持される()
    {
        $this->問い合わせを用意();
        $admin = User::factory()->create();

        $response = $this->actingAs($admin)->get('/admin/search?keyword=山田&gender=1');

        $response->assertStatus(200);
        $response->assertSee('value="山田"', false);
        $response->assertSee("<option value=\"1\" selected", false);
    }
}
