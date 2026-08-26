<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /** @test */
    public function トップページはお問い合わせフォームへリダイレクトする()
    {
        $this->get('/')->assertRedirect('/contact');
    }

    /** @test */
    public function お問い合わせフォームが表示できる()
    {
        $this->get('/contact')->assertStatus(200);
    }
}
