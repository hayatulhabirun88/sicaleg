<?php

namespace App\Http\Livewire;

use App\Models\Dpt;
use App\Models\Caleg;
use Livewire\Component;
use App\Models\Pendukung;
use Illuminate\Support\Facades\DB;

class ReportIndex extends Component
{
    public function render()
    {
        $pendukungs = Pendukung::select('caleg_id', DB::raw('count(*) as total'))
             ->groupBy('caleg_id')
             ->get();

        $kecamatans = Dpt::select('kecamatan', DB::raw('COUNT(*) AS jumlah'))
        ->groupBy('kecamatan')
        ->get();


        $dapil1 = [];
        $dapil2 = [];
        $dapil3 = [];
        
        foreach ($pendukungs as $pendukung) {
            if ($pendukung->caleg->dapil == 'DAPIL 1') {
                $dapil1[] = [
                    'caleg' => $pendukung->caleg->name,
                    'total' => $pendukung->total
                ];
            } 
            if ($pendukung->caleg->dapil == 'DAPIL 2') {
                $dapil2[] = [
                    'caleg' => $pendukung->caleg->name,
                    'total' => $pendukung->total
                ];
            }
            if ($pendukung->caleg->dapil == 'DAPIL 3') {
                $dapil3[] = [
                    'caleg' => $pendukung->caleg->name,
                    'total' => $pendukung->total
                ];
            }

        }

        $dapil1kecamatan = 0;
        $dapil2kecamatan = 0;
        $dapil3kecamatan = 0;

        foreach ($kecamatans as $kecamatan) {
            if (in_array($kecamatan->kecamatan, ['MURHUM', 'BETOAMBARI', 'BATUPOARO'])) {
                $dapil1kecamatan += $kecamatan->jumlah ;
            }
            if (in_array($kecamatan->kecamatan, ['BUNGI', 'KOKALUKUNA', 'LEA-LEA','SORAWOLIO'])) {
                $dapil2kecamatan += $kecamatan->jumlah;
            }
            if (in_array($kecamatan->kecamatan, ['WOLIO'])) {
                $dapil3kecamatan += $kecamatan->jumlah;
            }
        }

        $dapilcaleg1 = [];
        $dapiltotal1 = [];

        foreach ($dapil1 as $key => $value) {
            $dapilcaleg1[] = $value['caleg'];
            $dapiltotal1[] = $value['total'];
        }

        $dapilcaleg2 = [];
        $dapiltotal2 = [];

        foreach ($dapil2 as $key => $value) {
            $dapilcaleg2[] = $value['caleg'];
            $dapiltotal2[] = $value['total'];
        }

        $dapilcaleg3 = [];
        $dapiltotal3 = [];

        foreach ($dapil3 as $key => $value) {
            $dapilcaleg3[] = $value['caleg'];
            $dapiltotal3[] = $value['total'];
        }

        $pendukung = [
            'dapilcaleg1' => $dapilcaleg1,
            'dapiltotal1' => $dapiltotal1,
            'dapilcaleg2' => $dapilcaleg2,
            'dapiltotal2' => $dapiltotal2,
            'dapilcaleg3' => $dapilcaleg3,
            'dapiltotal3' => $dapiltotal3,
        ];

        $targetdapil1 = $dapil1kecamatan / 11;
        $targetdapil2 = $dapil2kecamatan / 7;
        $targetdapil3 = $dapil3kecamatan / 7;


        return view('livewire.report-index',[
            'pendukung' => $pendukung,
            'dapil1' => $dapil1,
            'dapil2' => $dapil2,
            'dapil3' => $dapil3,
            'targetdapil1' => $targetdapil1,
            'targetdapil2' => $targetdapil2,
            'targetdapil3' => $targetdapil3,
        ])->layout('report.index');
    }
}
