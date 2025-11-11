<?php

namespace Database\Factories;

use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactFactory extends Factory
{
    protected $faker;

public function __construct(...$args)
{
    parent::__construct(...$args);
    $this->faker = FakerFactory::create('ja_JP');
}
    public function definition()
    {
        return [
            'category_id' => $this->faker->numberBetween(1, 5),
            'first_name'  => $this->faker->firstName,
            'last_name'   => $this->faker->lastName,
            'gender'      => $this->faker->numberBetween(1, 3),
            'email'       => $this->faker->unique()->safeEmail,
            'tel'         => $this->faker->phoneNumber,
            'address'     => $this->faker->address,
            'building'    => $this->faker->optional()->secondaryAddress,
            'detail' => $this->faker->randomElement([
            '商品の発送について確認したいです。',
            '注文内容を変更したいのですが可能でしょうか？',
            '返品の手続きを教えてください。',
            '支払い方法についてお問い合わせします。',
            'サイトの動作に関して質問があります。',
            ]),
            'created_at'  => now(),
            'updated_at'  => now(),
        ];
    }
}
