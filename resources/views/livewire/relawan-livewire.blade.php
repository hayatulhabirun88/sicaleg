<div class="container">

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-center">DAFTAR PENGGUNA</h1>
    <button wire:click="openCreate()" class="btn btn-primary">Tambah</button>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama</td>
                            <td>Email</td>
                            <td>No HP</td>
                            <td>Wilayah</td>
                            <td>Foto</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($relawans as $index => $relawan)
                            <tr>
                                <td>{{ $index + $relawans->firstItem() }}</td>
                                <td>{{ $relawan->name }}</td>
                                <td>{{ $relawan->email }}</td>
                                <td>{{ $relawan->no_hp }}</td>
                                <td>{{ $relawan->wilayah }}</td>
                                <td> <img src="{{ asset('/storage/photos/' . $relawan->foto) }}" alt="foto"
                                        width="50"></td>
                                <td>
                                    <button wire:click="edit({{ $relawan->id }})" class="btn btn-sm btn-primary"><i
                                            class="fa-solid fa-pen-to-square"></i></button>
                                    <button wire:click="delete({{ $relawan->id }})" class="btn btn-sm btn-danger"><i
                                            class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $relawans->links() }}

            </div>
        </div>
    </div>


    <div class="modal " tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"
        style="{{ $isModalOpen ? 'display: block;' : '' }}" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $relawanId ? 'Edit Post' : 'Tambah Post' }}</h5>
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input wire:model="name" type="text" class="form-control"
                                    placeholder="Masukan nama...">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input wire:model="email" type="text" class="form-control"
                                    placeholder="Masukan email...">
                                @error('email')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input wire:model="password" type="password" class="form-control"
                                    placeholder="Masukan password...">
                                @error('password')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="noHp">No HP</label>
                                <input wire:model="noHp" type="text" class="form-control"
                                    placeholder="Masukan no hp...">
                                @error('noHp')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="wilayah">Wilayah</label>
                                <select id="wilayah" wire:model="wilayah" class="form-control" name="">
                                    <option value="">-- Pilih Wilayah --</option>
                                    <option value="DAPIL 1">DAPIL 1</option>
                                    <option value="DAPIL 2">DAPIL 2</option>
                                    <option value="DAPIL 3">DAPIL 3</option>
                                </select>
                                @error('wilayah')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="level">Level</label>
                                <select id="level" wire:model="level" class="form-control" name="">
                                    <option value="">-- Pilih Level --</option>
                                    <option value="admin">Admin</option>
                                    <option value="relawan">Relawan</option>
                                    <option value="caleg">Caleg</option>
                                </select>
                                @error('level')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="foto">Foto</label>
                                <input wire:model="foto" type="file" class="form-control">
                                @error('foto')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button wire:click="closeModal" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Batal</button>
                    <button wire:click="{{ $relawanId ? 'update' : 'create' }}" type="button"
                        class="btn btn-primary">{{ $relawanId ? 'Perbarui' : 'Tambah' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
