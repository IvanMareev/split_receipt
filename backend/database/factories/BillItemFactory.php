<?php

namespace Database\Factories;

use App\Models\Bill;
use App\Models\User;
use App\Models\BillItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillItemFactory extends Factory
{
    protected $model = BillItem::class;

    public function definition()
    {
        return [
            'bill_id' => Bill::factory(), // создаст связанный счет, если не передан вручную
            'creator_id' => User::factory(), // создаст пользователя, если не передан вручную
            'title' => $this->faker->sentence(3),
            'category' => $this->faker->randomElement(['food', 'transport', 'utilities', 'other']),
            'amount' => $this->faker->randomFloat(2, 10, 1000),
            'description' => $this->faker->optional()->text(100),
        ];
    }
}
