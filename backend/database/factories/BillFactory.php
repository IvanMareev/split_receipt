<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Bill;
use Illuminate\Database\Eloquent\Factories\Factory;

class BillFactory extends Factory
{
    protected $model = Bill::class;

    public function definition()
    {
        return [
            'creator_id' => User::factory(),
            'total_sum' => 0, // можно пересчитать после добавления items
            'payment_date' => $this->faker->date(),
            'description' => $this->faker->sentence(),
            'status' => 'pending',
        ];
    }
}
