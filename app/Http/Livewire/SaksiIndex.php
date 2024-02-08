<?php

namespace App\Http\Livewire;

use App\Models\Tps;
use App\Models\Saksi;
use App\Models\Suara;
use Livewire\Component;
use Livewire\WithPagination;

class SaksiIndex extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $isModalOpen = false;
    public $statusSaksi = "Aktif";
    public $tambahSaksi, $saksiId, $tpsId, $no_hp, $alamat, $name;

    public function tambahSaksi()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInput();
    }

    public function resetInput()
    {
        $this->name = '';
        $this->tpsId = '';
        $this->no_hp = '';
        $this->alamat = '';
        $this->saksiId = '';
        $this->saksiStatus = "Aktif";
    }

    public function create()
    {
        $this->validate([
            'name' => 'required',
            'no_hp' => 'required|regex:/^[0-9()+\- ]{9,15}$/|unique:saksis,no_hp,'.$this->no_hp,
            'tpsId' => 'required|numeric|unique:saksis,tps_id,'.$this->tpsId,
        ],[
            'name.required' => 'Nama harus diisi',
            'no_hp.required' => 'No HP harus diisi',
            'no_hp.regex' => 'Format no hp harus benar',
            'no_hp.unique' => 'Nomor hp yang anda masukan sudah ada',
            'tpsId.required' => 'TPS harus diisi',
            'tpsId.numeric' => 'TPS harus angka',
            'tpsId.unique' => 'TPS sudah ada'
        ]);

        if ($this->statusSaksi == true) {
            $status = "Aktif";
        } else {
            $status = "Tidak Aktif";
        }

        Saksi::create([
            'nama_lengkap' => $this->name,
            'no_hp' => $this->no_hp,
            'tps_id' => $this->tpsId,
            'alamat' => $this->alamat,
            'status' => $status
        ]);

        session()->flash('success', 'Data Saksi berhasil tambah.');

        $this->closeModal();

    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'no_hp' => 'required|regex:/^[0-9()+\- ]{9,15}$/|unique:saksis,no_hp,'.$this->saksiId,
            'tpsId' => 'required|numeric|unique:saksis,tps_id,'.$this->saksiId,
        ],[
            'name.required' => 'nama harus diisi',
            'no_hp.required' => 'no hp harus diisi',
            'no_hp.regex' => 'format no hp harus benar',
            'no_hp.unique' => 'nomor hp yang anda masukan sudah ada',
            'tpsId.required' => 'tps id harus diisi',
            'tpsId.numeric' => 'tps id harus angka',
            'tpsId.unique' => 'tps id sudah ada'
        ]);

        if ($this->statusSaksi == true) {
            $status = "Aktif";
        } else {
            $status = "Tidak Aktif";
        }

        $saksi = Saksi::findOrFail($this->saksiId);

        $suara = Suara::where('tps_id', $saksi->tps_id)->get();
        foreach ($suara as $s) {
            $s->saksi_id = NULL;
            $s->update();
        }

        $saksi->nama_lengkap = $this->name;
        $saksi->alamat = $this->alamat;
        $saksi->no_hp = $this->no_hp;
        $saksi->tps_id = $this->tpsId;
        $saksi->status = $status;

        $saksi->update();


        session()->flash('success', 'Data Saksi berhasil update.');
        $this->closeModal();
        $this->resetInput();
    }

    public function edit($id)
    {
        $saksi = Saksi::findOrFail($id);

        $this->saksiId = $saksi->id;
        $this->name = $saksi->nama_lengkap;
        $this->alamat = $saksi->alamat;
        $this->no_hp = $saksi->no_hp;
        $this->tpsId = $saksi->tps_id;
        $this->statusSaksi = $saksi->status;

        $this->tambahSaksi();
    }

    public function delete($id)
    {
        $saksi = Saksi::findOrFail($id);
        session()->flash('success', 'Data Saksi berhasil dihapus.');
    }

    public function aktif($id)
    {
        $saksi = Saksi::findOrFail($id);

        $saksi->status = "Aktif";
        $saksi->update();

        session()->flash('success', 'Data Status berhasil ubah.');

    }

    public function tidakAktif($id)
    {
        $saksi = Saksi::findOrFail($id);

        $saksi->status = "Tidak Aktif";
        $saksi->update();

        session()->flash('success', 'Data Status berhasil ubah.');

    }

    public function render()
    {
        return view('livewire.saksi-index', [
            'saksi' => Saksi::orderBy('id', 'DESC')->paginate(10),
            'listTps' => Tps::all() 
        ]);
    }
}
