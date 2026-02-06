<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'nama' => 'Obat',
                'kode' => 'OBT'
            ],
            [
                'nama' => 'Alat Kesehatan',
                'kode' => 'ALK'
            ],
            [
                'nama' => 'Material Kesehatan',
                'kode' => 'MAT'
            ],
            [
                'nama' => 'ATK',
                'kode' => 'ATK'
            ],
            [
                'nama' => 'Umum',
                'kode' => 'UMM'
            ],
        ];

        foreach ($data as $row) {
            Category::updateOrCreate(
                ['kode' => $row['kode']],
                ['nama' => $row['nama']]
            );
        }
    }
}
