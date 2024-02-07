<?php

namespace App\Http\Livewire;

use App\Models\Tps;
use App\Models\Caleg;
use App\Models\Suara;
use App\Models\Partai;
use Livewire\Component;

class SuaraInput extends Component
{
    public $tps, $partaiId, $selectedPartai, $calegId, $jumlahSuara;


    public function updatedPartaiId()
    {
        $this->selectedPartai = Caleg::where('partai_id', $this->partaiId)->get();
    }

    public function create()
    {
        foreach ($this->jumlahSuara as $pId => $jml) {
            foreach ($jml as $k => $value) {
                if ($k == 0) {
                    $suaraPartai = Suara::where('tps_id', $this->tps)->where('partai_id', $pId)->where('caleg_id', 0)->first();
                    if ($suaraPartai) {
                        $suaraPartai->jumlah = preg_replace("/[^0-9]/","",$value);
                        $suaraPartai->update();
                    } else {
                        Suara::firstOrCreate([
                            'saksi_id' => NULL,
                            'caleg_id' => 0,
                            'tps_id' => $this->tps,
                            'partai_id' => $pId,
                            'jumlah' => preg_replace("/[^0-9]/","",$value)
                        ]);
                    }
                } else {
                    $suara = Suara::where('tps_id', $this->tps)->where('partai_id', $pId)->where('caleg_id', $k)->first();
                    if ($suara) {
                        $suara->jumlah = preg_replace("/[^0-9]/","",$value);
                        $suara->update();
                    } else {
                        Suara::firstOrCreate([
                            'saksi_id' => NULL,
                            'caleg_id' => $k,
                            'tps_id' => $this->tps,
                            'partai_id' => $pId,
                            'jumlah' => preg_replace("/[^0-9]/","",$value)
                        ]);
                    }
                }
            }
        }

        $this->resetInputs();
    }

    public function resetInputs()
    {
        $this->jumlahSuara = '';
    }


    public function render()
    {
        $partai = Partai::all();
        $selectTps = Tps::all();
        return view('livewire.suara-input',[
            'partai' => $partai,
            'selectTps' => $selectTps
        ]);
    }
}
