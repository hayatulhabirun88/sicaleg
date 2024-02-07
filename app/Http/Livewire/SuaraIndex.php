<?php

namespace App\Http\Livewire;

use App\Models\Caleg;
use App\Models\Partai;
use Livewire\Component;

class SuaraIndex extends Component
{
    public $partai;

    public function mount()
    {
        $this->partai = Partai::all();
    }


    public function reloadPage()
    {
        // Logika pembaruan atau reload halaman di sini
        // Anda dapat menambahkan logika pembaruan yang sesuai dengan kebutuhan aplikasi Anda
        // Misalnya: $this->data = ...;
        $this->partai = Partai::all();
        $this->emit('refreshPage');
    }


    public function render()
    {
        return view('livewire.suara-index',[

            'caleg' => Caleg::join('partai', 'calegs.partai_id', '=', 'partai.id')->get(),

        ]);
    }
}
