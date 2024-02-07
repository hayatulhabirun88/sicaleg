<?php

namespace App\Http\Livewire;

use App\Models\Tps;
use Livewire\Component;
use Livewire\WithPagination;

class TpsIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $isModalOpen = false;
    public $tpsId, $namaTps, $kelurahan, $kecamatan;

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function resetInput()
    {
        $this->namaTps = '';
        $this->kelurahan = '';
        $this->kecamatan = '';
        $this->tpsId = '';
    }

    public function create()
    {
        $this->validate([
            'namaTps' => 'required',
            'kelurahan' => 'required',
            'kecamatan' => 'required',
        ],[
            'namaTps.required' => 'nama harus diisi',
            'kelurahan.required' => 'kelurahan harus diisi',
            'kecamatan.required' => 'kecamatan harus diisi',
        ]);


        Tps::create([
            'name' => $this->namaTps,
            'kelurahan' => $this->kelurahan,
            'kecamatan' => $this->kecamatan,
        ]);

        session()->flash('success', 'Data TPS berhasil tambah.');

        $this->closeModal();

    }

    public function edit($id)
    {
        $tps = Tps::findOrFail($id);

        $this->tpsId = $tps->id;
        $this->namaTps = $tps->name;
        $this->kelurahan = $tps->kelurahan;
        $this->kecamatan = $tps->kecamatan;

        $this->openModal();
    }

    public function update()
    {
        

        $this->validate([
            'namaTps' => 'required|unique:tps,name,'.$this->tpsId,
            'kelurahan' => 'required',
            'kecamatan' => 'required',
        ],[
            'namaTps.required' => 'nama harus diisi',
            'kelurahan.required' => 'kelurahan harus diisi',
            'kecamatan.required' => 'kecamatan harus diisi',
        ]);

        $tps = Tps::findOrFail($this->tpsId);
        $tps->name = $this->namaTps;
        $tps->kelurahan = $this->kelurahan;
        $tps->kecamatan = $this->kecamatan;

        $tps->update();

        session()->flash('success', 'Data TPS berhasil update.');
        $this->closeModal();


    }

    public function delete($id)
    {
        $tps = Tps::findOrFail($id);

        $tps->delete();

        session()->flash('success', 'Data TPS berhasil dihapus.');
    }

    
    public function render()
    {
        return view('livewire.tps-index', [
            'tps' => Tps::orderBy('id', 'DESC')->paginate(10)
        ]);
    }
}
