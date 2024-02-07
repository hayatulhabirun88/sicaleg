<?php

namespace App\Http\Livewire;

use App\Models\Caleg;
use App\Models\Partai;
use Livewire\Component;
use Livewire\WithPagination;

class CalegLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $isModalOpen = false;
    public $calegId;
    public $name, $partai, $noUrut, $sts, $gambar, $dapil;

    public function render()
    {
        $calegs = Caleg::orderBy('id', 'DESC')->paginate(10);
        return view('livewire.caleg-livewire',[
            'calegs' => $calegs,
            'listPartai' => Partai::all()
        ])->layout('caleg.index');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function openCreate()
    {
        $this->resetInputs();
        $this->partai = 'PDI Perjuangan';
        $this->sts = 1;
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function create()
    {
        $this->validate([
            'name' => 'required',
            'partai' => 'required',
            'noUrut' => 'required',
            'sts' => 'required'
        ]);

        Caleg::create([
            'name' => $this->name,
            'partai' => $this->partai,
            'no_urut' => $this->noUrut,
            'sts' => $this->sts,
            'gambar' => $this->gambar
        ]);

        session()->flash('success', 'Data Caleg berhasil tambah.');
        $this->closeModal();

    }

    public function edit($id)
    {
        $caleg = Caleg::findOrFail($id);

        $this->calegId = $caleg->id;
        $this->name = $caleg->name;
        $this->partai = $caleg->partai;
        $this->noUrut = $caleg->no_urut;
        $this->sts = $caleg->sts;
        $this->gambar = $caleg->gambar;
        $this->dapil = $caleg->dapil;

        $this->openModal();

    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'partai' => 'required',
            'noUrut' => 'required',
            'sts' => 'required'
        ]);

        Caleg::where('id', $this->calegId)->update([
            'name' => $this->name,
            'partai' => $this->partai,
            'no_urut' => $this->noUrut,
            'sts' => $this->sts,
            'gambar' => $this->gambar,
            'dapil' => $this->dapil
        ]);

        session()->flash('success', 'Data Caleg berhasil update.');
        $this->resetInputs();
        $this->closeModal();
    }

    public function delete($id){

        Caleg::findOrFail($id)->delete();
        session()->flash('message', 'DPT berhasil dihapus.');

    }

    private function resetInputs()
    {
        $this->name = '';
        $this->partai = '';
        $this->noUrut = '';
        $this->sts = '';
        $this->gambar = '';
        $this->dapil = '';
    }

    public function dukung($id)
    {
        $caleg = Caleg::findOrFail($id);
        $caleg->sts = 1;
        $caleg->update();
        
        session()->flash('message', 'Caleg berhasil ubah status.');

    }

    public function lawan($id)
    {
        $caleg = Caleg::findOrFail($id);
        $caleg->sts = NULL;
        $caleg->update();
        session()->flash('message', 'Caleg berhasil ubah status.');
    }





}
