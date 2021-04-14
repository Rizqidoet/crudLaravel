<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $category = [
            [
                'created_at'    => '2021-04-11 00:00:00',
                'updated_at'    => '2021-04-11 00:00:00',
                'type_id'          => '1',
                'name'          => 'Cemilan',
                'status'          => '1',
            ],
            [
                'created_at'    => '2021-04-11 00:00:00',
                'updated_at'    => '2021-04-11 00:00:00',
                'type_id'          => '2',
                'name'          => 'Makanan Pembuka',
                'status'          => '1',
            ],
            [
                'created_at'    => '2021-04-11 00:00:00',
                'updated_at'    => '2021-04-11 00:00:00',
                'type_id'          => '3',
                'name'          => 'Makanan Utama',
                'status'          => '1',
            ],
            [
                'created_at'    => '2021-04-11 00:00:00',
                'updated_at'    => '2021-04-11 00:00:00',
                'type_id'          => '4',
                'name'          => 'Makanan Penutup',
                'status'          => '1',
            ],
            [
                'created_at'    => '2021-04-11 00:00:00',
                'updated_at'    => '2021-04-11 00:00:00',
                'type_id'          => '5',
                'name'          => 'Minuman',
                'status'          => '1',
            ],
        ];
        Category::insert($category);
    }
}
