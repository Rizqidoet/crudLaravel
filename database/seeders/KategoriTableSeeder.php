<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class KategoriTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategori = [
            [
                'name'          => 'Cemilan',
                'created_at'    => '2021-04-11 00:00:00',
                'updated_at'    => '2021-04-11 00:00:00',
            ],
            [
                'name'          => 'Makanan Pembuka',
                'created_at'    => '2021-04-11 00:00:00',
                'updated_at'    => '2021-04-11 00:00:00',
            ],
            [
                'name'          => 'Makanan Utama',
                'created_at'    => '2021-04-11 00:00:00',
                'updated_at'    => '2021-04-11 00:00:00',
            ],
            [
                'name'          => 'Makanan Penutup',
                'created_at'    => '2021-04-11 00:00:00',
                'updated_at'    => '2021-04-11 00:00:00',
            ],
            [
                'name'          => 'Minuman',
                'created_at'    => '2021-04-11 00:00:00',
                'updated_at'    => '2021-04-11 00:00:00',
            ],
        ];

        Kategori::insert($kategori);
    }
}
