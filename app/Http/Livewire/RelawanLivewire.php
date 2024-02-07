<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Caleg;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class RelawanLivewire extends Component
{
    use WithPagination;
    use WithFileUploads;

    protected $paginationTheme = 'bootstrap';
    public $isModalOpen = false;
    public $level = 'relawan';
    public $relawanId, $name, $email, $password, $noHp, $wilayah, $currentPhoto;
    public $foto;


    public function openModal()
    {
        $this->isModalOpen = true;
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
        $this->resetInputs();
    }

    public function openCreate()
    {
        $this->isModalOpen = true;
        $this->resetInputs();
    }

    public function create()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
        ]);

        if (isset($this->foto)) {
            $this->validate([
                'foto' => 'image|mimes:jpg,jpeg,png,svg'
            ]);

            $randomString = Str::random(30);
            $extension = $this->foto->getClientOriginalExtension(); 
    
            $fileName = $randomString . '.' . $extension; 
            $this->foto->storeAs('public/photos', $fileName);

        } else {
            $fileName = '';
        }

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'no_hp' => $this->noHp,
            'wilayah' => $this->wilayah,
            'level' => $this->level,
            'foto' => $fileName,
        ]);

        session()->flash('success', 'Data Relawan berhasil tambah.');

        $this->closeModal();

    }

    public function edit($id)
    {
        $relawan = User::findOrFail($id);

        $this->relawanId = $relawan->id;
        $this->name = $relawan->name;
        $this->email = $relawan->email;
        $this->noHp = $relawan->no_hp;
        $this->wilayah = $relawan->wilayah;
        $this->level = $relawan->level;

        $this->openModal();
    }

    public function update()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,'. $this->relawanId,
        ]);



        $relawan = User::findOrFail($this->relawanId);
        
        $relawan->name = $this->name;
        $relawan->email = $this->email;
        $relawan->no_hp = $this->noHp;
        $relawan->wilayah = $this->wilayah;
        $relawan->level = $this->level;

        if (isset($this->foto)) {
            $this->validate([
                'foto' => 'image|mimes:jpg,jpeg,png,svg',
            ]);
            # code...
            $randomString = Str::random(30);
            $extension = $this->foto->getClientOriginalExtension(); 
    
            $fileName = $randomString . '.' . $extension; 
            $this->foto->storeAs('public/photos', $fileName);
            $photoData = User::find($this->relawanId);
            $this->currentPhoto = $photoData->foto ?? null;

            if ($this->currentPhoto) {
                Storage::disk('public')->delete('photos/' . $this->currentPhoto);
            }
            $relawan->foto = $fileName;
        }

        if ($this->password) {
            $relawan->password = Hash::make($this->password);
        }

        $relawan->update();

        session()->flash('success', 'Data Relawan berhasil update.');
        $this->resetInputs();
        $this->closeModal();
    }

    public function render()
    {
        
        return view('livewire.relawan-livewire',[
            'relawans' => User::paginate(10),
        ])->layout('relawan.index');
    }

    public function delete($id)
    {
        $photoData = User::findOrFail($id);

        if ($photoData) {
            Storage::disk('public')->delete('photos/' . $photoData->foto);
        }

        $photoData->delete();

        session()->flash('success', 'Data Relawan berhasil dihapus.');
    }

    private function resetInputs()
    {
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->noHp = '';
        $this->wilayah = '';
        $this->foto = NULL;
        $this->level = 'relawan';
    }
}
