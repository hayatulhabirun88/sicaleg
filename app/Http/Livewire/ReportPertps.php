<?php

namespace App\Http\Livewire;

use App\Models\Dpt;
use App\Models\Caleg;
use Livewire\Component;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Pendukung;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class ReportPertps extends Component
{
    use WithPagination;

    public $dapil, $calegs, $calegId, $calegName, $calegNameView, $reload, $perKelurahan, $laki2, $perempuan;

    public $newResult = [];
    public $dapilView = [];

    public function updatedDapil($value)
    {
        $this->resetInputs();
        $this->calegName = Caleg::where('dapil', $value)->get();
        $this->dapil = $value;
    }

    public function resetInputs()
    {
        $this->dapil = '';
        $this->calegs = '';
    }

    public function submitForm()
    {
        $this->validate([
            'calegs' => 'required'
        ]);

        $this->calegNameView = Caleg::find($this->calegs)->name;

        DB::statement("SET sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY',''))");
        $dpts = Dpt::join('pendukungs', 'dpts.id', '=', 'pendukungs.dpt_id')
        ->join('calegs', 'pendukungs.caleg_id', '=', 'calegs.id')
        ->groupBy('calegs.id','dpts.tps')
        ->selectRaw('dpts.*, calegs.name as nama_caleg, COUNT(*) as total_dukungan')
        ->where('calegs.id', $this->calegs)
        ->orderBy('total_dukungan', 'DESC')
        ->get();

        $laki2 = Dpt::join('pendukungs', 'dpts.id', '=', 'pendukungs.dpt_id')
        ->join('calegs', 'pendukungs.caleg_id', '=', 'calegs.id')
        ->where('calegs.id', $this->calegs)->where('dpts.jenis_kelamin', 'L')
        ->count();
        $perempuan = Dpt::join('pendukungs', 'dpts.id', '=', 'pendukungs.dpt_id')
        ->join('calegs', 'pendukungs.caleg_id', '=', 'calegs.id')
        ->where('calegs.id', $this->calegs)->where('dpts.jenis_kelamin', 'P')
        ->count();

        

        $this->laki2 = $laki2;
        $this->perempuan = $perempuan;

        if (count($dpts) > 0) {

            $dapil1 = [];
            $dapil2 = [];
            $dapil3 = [];

            foreach ($dpts as $dpt) {
                if (in_array(trim($dpt->kecamatan), ['MURHUM', 'BETOAMBARI', 'BATUPOARO'])) {
                    $dapil1[] = $dpt;
                }
    
                if (in_array(trim($dpt->kecamatan), ['BUNGI', 'KOKALUKUNA', 'LEA-LEA','SORAWOLIO'])) {
                    $dapil2[] = $dpt;
                }
    
                if (in_array(trim($dpt->kecamatan), ['WOLIO'])) {
                    $dapil3[] = $dpt;
                }
            }
        }else {
            $dapil1 = [];
            $dapil2 = [];
            $dapil3 = [];
        }
        
        if ($this->calegs) {
            # code...
            
            if ($this->dapil == 'DAPIL 1') {
                $this->dapilView = $dapil1;
            } elseif ($this->dapil == 'DAPIL 2') {
                $this->dapilView = $dapil2;
            } elseif ($this->dapil == 'DAPIL 3') {
                $this->dapilView = $dapil3;
            }
        }

        $result = [];

        foreach ($dpts as $item) {
            $dukungan = [
                'tps' => $item->tps,
                'total_dukungan' => $item->total_dukungan,
            ];

            $key = $item->kecamatan . ":" . $item->kelurahan;

            if (isset($result[$key])) {
                $result[$key]['data'][] = $dukungan;
            } else {
                $result[$key] = [
                    'kecamatan' => $item->kecamatan,
                    'kelurahan' => $item->kelurahan,
                    'data' => [$dukungan]
                ];
            }
        }

        $output = array_values($result);
        

        $this->newResult = $output;

    }

    public function render()
    {
        $kelurahan = Kelurahan::all();

        $kecamatan = Kecamatan::all();

        return view('livewire.report-pertps',
        [
            'kelurahan' => $kelurahan,
            'kecamatan' => $kecamatan,
        ])->layout('report.pertps');
    }
}
