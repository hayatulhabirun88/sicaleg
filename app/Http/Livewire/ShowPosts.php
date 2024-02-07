<?php

namespace App\Http\Livewire;

use App\Models\Dpt;
use App\Models\User;
use App\Models\Caleg;
use Livewire\Component;
use App\Models\Pendukung;
use Livewire\WithPagination;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Session\SessionManager;

class ShowPosts extends Component
{
    use WithPagination;

    public $searchNama, $searchUmur, $searchJk, $searchKelurahan;
    public $nama, $umur, $jenisKelamin, $kelurahan, $kecamatan, $rt, $rw, $tps, $nik, $dukungan, $alamat, $noKk, $tglLahir, $foto, $dptId, $caleg, $relawan, $calegByDapil;

    public $isModalOpen = false;
    public $isModalOpenCaleg = false;

    protected $paginationTheme = 'bootstrap';
    protected $queryString = ['searchNama', 'searchUmur', 'searchJk', 'searchKelurahan'];

    public function updatingSearchNama()
    {
        $this->resetPage();
    }

    public function updatingSearchUmur()
    {
        $this->resetPage();
    }

    public function updatingSearchJk()
    {
        $this->resetPage();
    }
    public function updatingSearchKelurahan()
    {
        $this->resetPage();
    }

    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function edit($id)
    {
        $dpt = Dpt::findOrFail($id);

        $this->dptId = $dpt->id;
        $this->nama = $dpt->nama;
        $this->umur = $dpt->umur;
        $this->jenisKelamin = $dpt->jenis_kelamin;
        $this->kelurahan = $dpt->kelurahan;
        $this->kecamatan = $dpt->kecamatan;
        $this->rt = $dpt->rt;
        $this->rw = $dpt->rw;
        $this->tps = $dpt->tps;
        $this->nik = $dpt->nik;
        $this->dukungan = $dpt->dukungan;
        $this->alamat = $dpt->alamat;
        $this->noKk = $dpt->no_kk;
        $this->tglLahir = $dpt->tgl_lahir;
        $this->foto = $dpt->foto;

        $this->openModal();

    }

    public function update()
    {
        $post = Dpt::findOrFail($this->dptId);
        $post->update([
            'nama' => $this->nama,
            'umur' => $this->umur,
            'jenis_kelamin' => $this->jenisKelamin,
            'kelurahan' => $this->kelurahan,
            'kecamatan' => $this->kecamatan,
            'rt' => $this->rt,
            'rw' => $this->rw,
            'tps' => $this->tps,
            'nik' => $this->nik,
            'dukungan' => $this->dukungan,
            'alamat' => $this->alamat,
            'noKk' => $this->noKk,
            'tglLahir' => $this->tglLahir,
            'foto' => $this->foto,
        ]);

        session()->flash('success', 'DPT berhasil diperbarui.');
        $this->closeModal();

    }

    public function delete($id){

        Dpt::findOrFail($id)->delete();
        session()->flash('success', 'DPT berhasil dihapus.');

    }

    public function deletePendukung($id){
        Pendukung::findOrFail($id)->delete();
        session()->flash('success', 'DPT berhasil di hapus');
    }

    public function hapusPendukung($id)
    {
        Pendukung::findOrFail($id)->delete();
        session()->flash('success', 'DPT berhasil dihapus.');
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->isModalOpenCaleg = false;
    }

    public function tambahDukungan($id)
    {

        $dtpendukung = Pendukung::where('user_id', Auth::user()->id)->where('dpt_id', $id)->count();
        $calegs = Caleg::all();
        if (Pendukung::where('user_id', Auth::user()->id)->where('dpt_id', $id)->count() > 0) {
            session()->flash('error','Gagal, anda telah menginput pemilih sebelumnya');
            redirect()->to('/');
        }

        $this->dptId = $id;
        $this->calegByDapil = '';
        
        $this->calegByDapil = $calegs;

        $this->isModalOpenCaleg = true;
    }

    public function updateDukungan()
    {
        $this->validate([
            'dptId' => 'required',
            'caleg' => 'required'
        ]);

        $dpt = Dpt::find($this->dptId);
        $caleg = Caleg::find($this->caleg);
        if (Auth::user()->level != 'admin') {
            $this->relawan = Auth::user()->id;
        }

        if ($caleg) {
            Pendukung::create([
                'dpt_id' => $this->dptId,
                'caleg_id' => $this->caleg,
                'user_id' => $this->relawan
            ]);
    
            session()->flash('success', 'Dukungan berhasil ditambah.');
            $this->closeModal();
        } else {
            session()->flash('error', 'Silahkan input caleg terlebih dahulu.');
            $this->closeModal();
        }

    }

    public function render()
    {
        if (Auth::user()->level == 'admin') {
            # code...
            if ($this->searchNama || $this->searchUmur || $this->searchJk || $this->searchKelurahan) {
    
                $dpts = Dpt::where('nama', 'like', '%'.$this->searchNama.'%')
                            ->where('umur', 'like', '%'.$this->searchUmur.'%')
                            ->where('jenis_kelamin', 'like', '%'.$this->searchJk.'%')
                            ->where('kelurahan', 'like', '%'.$this->searchKelurahan.'%')
                            ->paginate(10);
    
            }else {
                $dpts = Dpt::paginate(10);
            }
        } elseif (Auth::user()->level == 'relawan' && Auth::user()->wilayah != "") {
            
            if ($this->searchNama || $this->searchUmur || $this->searchJk || $this->searchKelurahan) {
                
                if (Auth::user()->wilayah == 'DAPIL 1') {

                    $dpts = Dpt::where('nama', 'like', '%' . $this->searchNama . '%')
                            ->where('umur', 'like', '%' . $this->searchUmur . '%')
                            ->where('jenis_kelamin', 'like', '%' . $this->searchJk . '%')
                            ->where('kelurahan', 'like', '%' . $this->searchKelurahan . '%')
                            ->where(function ($query) {
                                $query->where('kecamatan', 'BATUPOARO')
                                    ->orWhere('kecamatan', 'MURHUM')
                                    ->orWhere('kecamatan', 'BETOAMBARI');
                            })->paginate(5);

                } elseif (Auth::user()->wilayah == 'DAPIL 2') {

                    $dpts = Dpt::where('nama', 'like', '%'.$this->searchNama.'%')
                            ->where('umur', 'like', '%'.$this->searchUmur.'%')
                            ->where('jenis_kelamin', 'like', '%'.$this->searchJk.'%')
                            ->where('kelurahan', 'like', '%'.$this->searchKelurahan.'%')
                            ->where(function ($query) {
                                $query->where('kecamatan', 'BUNGI')
                                    ->orWhere('kecamatan', 'KOKALUKUNA')
                                    ->orWhere('kecamatan', 'LEA-LEA')
                                    ->orWhere('kecamatan', 'SORAWOLIO');
                            })->paginate(5);

                } elseif (Auth::user()->wilayah == 'DAPIL 3') {

                    $dpts = Dpt::where('nama', 'like', '%'.$this->searchNama.'%')
                            ->where('umur', 'like', '%'.$this->searchUmur.'%')
                            ->where('jenis_kelamin', 'like', '%'.$this->searchJk.'%')
                            ->where('kelurahan', 'like', '%'.$this->searchKelurahan.'%')
                            ->where('kecamatan', 'WOLIO')
                            ->paginate(5);

                }

            }else {
                
                if (Auth::user()->wilayah == 'DAPIL 1') {
                    
                    $dpts = Dpt::where('kecamatan', 'MURHUM')
                                ->orwhere('kecamatan', 'BETOAMBARI')
                                ->orwhere('kecamatan', 'BATUPOARO')
                                ->paginate(5);

                } elseif (Auth::user()->wilayah == 'DAPIL 2') {

                    $dpts = Dpt::where('kecamatan', 'BUNGI')
                                ->orwhere('kecamatan', 'KOKALUKUNA')
                                ->orwhere('kecamatan', 'LEA-LEA')
                                ->orwhere('kecamatan', 'SORAWOLIO')
                    ->paginate(5);

                } elseif (Auth::user()->wilayah == 'DAPIL 3') {

                    $dpts = Dpt::where('kecamatan', 'WOLIO')
                    ->paginate(5);

                } 
            }
        } else {
            $dpts = [];
        }


        $pendukungs = Pendukung::where('user_id', Auth::user()->id)->orderBy('id','desc')->take(20)->get();

        $relawans = User::where('level', 'relawan')->get();
        
        return view('livewire.show-posts', [
            'dpts' => $dpts,
            'relawans' => $relawans,
            'pendukungs' => $pendukungs,
        ])->layout('welcome');
    }
}
