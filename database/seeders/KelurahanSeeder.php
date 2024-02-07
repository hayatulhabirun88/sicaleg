<?php

namespace Database\Seeders;

use App\Models\Village;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KelurahanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kecamatan = Kecamatan::all();
        foreach ($kecamatan as $kec) {
            $kelurahan = Village::where('district_id', $kec->code)->get();
            foreach ($kelurahan as $kel) {
                Kelurahan::create([
                    'code'=> $kel->id,
                    'id_kec' => $kel->district_id,
                    'nama_kelurahan' => $kel->name
                ]);
            }
        }
        // $kelurahan = Kelurahan::where('')
    }
}
