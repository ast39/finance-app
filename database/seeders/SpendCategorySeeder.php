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
        SpendCategory::create([
            'title'     => 'Прочее',
            'parent_id' => null,
        ]);

        SpendCategory::create([
            'title'     => 'Еда',
            'parent_id' => null,
        ]);

        SpendCategory::create([
            'title'     => 'Здоровье',
            'parent_id' => null,
        ]);

        SpendCategory::create([
            'title'     => 'Досуг',
            'parent_id' => null,
        ]);

        SpendCategory::create([
            'title'     => 'Дети',
            'parent_id' => null,
        ]);

        $car_id = SpendCategory::create([
            'title'     => 'Автомобиль',
            'parent_id' => null,
        ])->category_id;

        SpendCategory::create([
            'title'     => 'Топливо',
            'parent_id' => $car_id,
        ]);

        SpendCategory::create([
            'title'     => 'Парковка',
            'parent_id' => $car_id,
        ]);

        SpendCategory::create([
            'title'     => 'Страховки',
            'parent_id' => $car_id,
        ]);

        SpendCategory::create([
            'title'     => 'Сервис',
            'parent_id' => $car_id,
        ]);
    }
}
