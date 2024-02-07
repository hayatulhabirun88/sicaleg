<?php

namespace Database\Seeders;

use App\Models\District;
use App\Models\Kecamatan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KecamatanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $district = District::where('regency_id', '7472')->get();

        foreach ($district as $kecamatan) {
            Kecamatan::create([
                'code' => $kecamatan->id,
                'id_kab' => $kecamatan->regency_id,
                'nama_kecamatan' => $kecamatan->name,
                'wilayah' => 'DAPIL 1'
            ]);
        }
    }
}
