<?php

namespace App\Http\Livewire;

use App\Models\Dpt;
use App\Models\User;
use App\Models\Caleg;
use Livewire\Component;
use App\Models\Pendukung;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class PendukungLivewire extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';
    public $isModalOpen = false;
    public $isOpenPendukung = false;
    public $pendukungId, $calegId, $userId, $dptId, $ket, $searchNama;
    public $namaLengkap, $nik, $umur, $jenisKelamin, $kelurahan, $kecamatan, $tps, $selectedKecamatan, $selectedKelurahan;

    protected $queryString = ['searchNama'];

    public function updatingSearchNama()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->getKecamatanData();
    }

    public function render()
    {
        if ($this->searchNama) {
            
            if (Auth::user()->level == "relawan") {
                $pendukung = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')
                ->where('dpts.nama', 'like', '%'.$this->searchNama.'%')
                ->orderBy('dpts.id', 'DESC')
                ->where('user_id', Auth::user()->id)
                ->paginate(10);
                $laki2 = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->where('user_id', Auth::user()->id)->where('dpts.jenis_kelamin', 'L')->count();
                $perempuan = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->where('user_id', Auth::user()->id)->where('dpts.jenis_kelamin', 'P')->count();
                $total = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->where('user_id', Auth::user()->id)->count();
                # code...
            }else {
                $pendukung = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')
                ->where('dpts.nama', 'like', '%'.$this->searchNama.'%')
                ->orderBy('dpts.id', 'DESC')
                ->paginate(10);
                $laki2 = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->where('dpts.jenis_kelamin', 'L')->count();
                $perempuan = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->where('dpts.jenis_kelamin', 'P')->count();
                $total = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->count();
            }

        }else {
            if (Auth::user()->level == "relawan") {
                $pendukung = Pendukung::with('dpts')->where('user_id', Auth::user()->id)->orderBy('pendukungs.id','DESC')->paginate(10);
                $laki2 = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->where('user_id', Auth::user()->id)->where('dpts.jenis_kelamin', 'L')->count();
                $perempuan = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->where('user_id', Auth::user()->id)->where('dpts.jenis_kelamin', 'P')->count();
                $total = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->where('user_id', Auth::user()->id)->count();
            }else {
                $pendukung = Pendukung::with('dpts')->orderBy('pendukungs.id','DESC')->paginate(10);
                $laki2 = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->where('dpts.jenis_kelamin', 'L')->count();
                $perempuan = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->where('dpts.jenis_kelamin', 'P')->count();
                $total = Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')->count();
            }
        }

        return view('livewire.pendukung-livewire',[
            'pendukungs' => $pendukung,
            'relawans' => User::where('level','relawan')->get(),
            'calegs' => Caleg::all(),
            'laki2' => $laki2,
            'perempuan' => $perempuan,
            'total' => $total,
        ])->layout('pendukung.index');
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function openCreate()
    {
        $this->resetInputs();
        $this->partai = 'PDI Perjuangan';
        $this->sts = 1;
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $pendukung = Pendukung::findOrFail($id);
        $this->pendukungId = $pendukung->id;
        $this->calegId = $pendukung->caleg_id;
        $this->userId = $pendukung->user_id;
        $this->dptId = $pendukung->dpt_id;
        $this->openModal();
    }

    public function update()
    {
        $this->validate([
            'calegId' => 'required',
            'userId' => 'required',
        ]);
        Pendukung::findOrFail($this->pendukungId)->update([
            'caleg_id' => $this->calegId,
            'user_id' => $this->userId,
            'dpt_id' => $this->dptId,
            'ket' => $this->ket,
        ]);

        session()->flash('success', 'Data Pendukung berhasil update.');
        $this->closeModal();
    }


    public function delete($id){
        Pendukung::findOrFail($id)->delete();
        session()->flash('success', 'Data Pendukung berhasil dihapus.');
    }

    public function tambahPendukung()
    {
        $this->isOpenPendukung = true;
    }

    public function closeTambahPendukung()
    {
        $this->isOpenPendukung = false;
    }

    public function getKecamatanData()
    {
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/districts/7415.json');
        $this->selectedKecamatan = $response->json();
    }

    public function getKelurahanData()
    {
        $response = Http::get('https://www.emsifa.com/api-wilayah-indonesia/api/villages/'.$this->kecamatan.'.json');
        $this->selectedKelurahan = $response->json();
    }

    public function create()
    {
        if ($this->nik) {
            $this->validate([
                'nik' => 'required|numeric|digits:16'
            ]);
        }

        $this->validate([
            'namaLengkap' => 'required'
        ]);

        $keykecamatan = array_search($this->kecamatan, array_column($this->selectedKecamatan, 'id'));
        $foundKecamatan = $this->selectedKecamatan[$keykecamatan];

        $keykelurahan = array_search($this->kelurahan, array_column($this->selectedKelurahan, 'id'));
        $foundKelurahan = $this->selectedKelurahan[$keykelurahan];

        $dpt = new Dpt;

        $dpt->nama = $this->namaLengkap;
        $dpt->umur = $this->umur;
        $dpt->jenis_kelamin = $this->jenisKelamin;
        $dpt->kecamatan = $foundKecamatan['name'];
        $dpt->kelurahan = $foundKelurahan['name'];
        $dpt->tps = $this->tps;

        $dpt->save();

        Pendukung::create([
            'dpt_id' => $dpt->id,
            'caleg_id' => 33,
        ]);

        session()->flash('success', 'Data Pendukung berhasil ditambah.');
        $this->closeTambahPendukung();

    }



}
