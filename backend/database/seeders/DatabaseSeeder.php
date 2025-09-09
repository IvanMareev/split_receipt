<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Bill;
use App\Models\BillItem;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Создадим пользователей
        $users = User::factory(10)->create();

        // Создадим счета и у каждого несколько items
        Bill::factory(20)
            ->has(BillItem::factory()->count(5), 'billItems') // по 5 позиций в каждом счете
            ->create();

        // Если нужно просто много items без привязки:
        // BillItem::factory(1000)->create();
    }
}
