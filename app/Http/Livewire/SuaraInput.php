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

    public function updatedJumlahSuara()
    {
            foreach ($this->jumlahSuara as $pId => $jml) {
                foreach ($jml as $k => $value) {
                    $jmlSuara = preg_replace("/[^0-9]/","",$value);
                    if ($jmlSuara == "") {
                        $jmlSuara = 0;
                    }
                    if ($k == 0) {
                        $suaraPartai = Suara::where('tps_id', $this->tps)->where('partai_id', $pId)->where('caleg_id', 0)->first();
                        if ($suaraPartai) {
                            $suaraPartai->jumlah = $jmlSuara;
                            $suaraPartai->update();
                        } else {

                            Suara::firstOrCreate([
                                'saksi_id' => NULL,
                                'caleg_id' => 0,
                                'tps_id' => $this->tps,
                                'partai_id' => $pId,
                                'jumlah' => $jmlSuara
                            ]);
                        }
                    } else {
                        $suara = Suara::where('tps_id', $this->tps)->where('partai_id', $pId)->where('caleg_id', $k)->first();
                        if ($suara) {
                            $suara->jumlah = $jmlSuara;
                            $suara->update();
                        } else {
                            Suara::firstOrCreate([
                                'saksi_id' => NULL,
                                'caleg_id' => $k,
                                'tps_id' => $this->tps,
                                'partai_id' => $pId,
                                'jumlah' => $jmlSuara
                            ]);
                        }
                    }
                }
            }
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
