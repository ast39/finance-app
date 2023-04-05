<?php

namespace Database\Seeders;

use App\Models\Spend\SpendCategory;
use Illuminate\Database\Seeder;

class SpendCategorySeeder extends Seeder {

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SpendCategory::create(['title' => 'Прочее']);
        SpendCategory::create(['title' => 'Еда']);
        SpendCategory::create(['title' => 'Здоровье']);
        SpendCategory::create(['title' => 'Досуг']);
        SpendCategory::create(['title' => 'Дети',]);
        SpendCategory::create(['title' => 'Топливо']);
        SpendCategory::create(['title' => 'Парковка']);
        SpendCategory::create(['title' => 'Страховки']);
        SpendCategory::create(['title' => 'Сервис']);
        SpendCategory::create(['title' => 'Подарки']);
        SpendCategory::create(['title' => 'Одежда']);
        SpendCategory::create(['title' => 'Техника']);
        SpendCategory::create(['title' => 'Мебель']);
        SpendCategory::create(['title' => 'Кредиты']);
        SpendCategory::create(['title' => 'Квартира']);
    }
}
