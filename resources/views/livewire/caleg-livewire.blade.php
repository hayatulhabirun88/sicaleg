<div class="container">

    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <h1 class="text-center">CALEG</h1>
    <button wire:click="openCreate()" class="btn btn-primary">Tambah</button>
    <div class="row mt-4">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Nama</td>
                            <td>Partai</td>
                            <td>No Urut</td>
                            <td>Status</td>
                            <td>Wilayah</td>
                            <td>Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($calegs as $index => $caleg)
                            <tr>
                                <td>{{ $index + $calegs->firstItem() }}</td>
                                <td>{{ $caleg->name }}</td>
                                <td>{{ $caleg->partai->nama_partai }}</td>
                                <td>{{ $caleg->no_urut }}</td>
                                <td>
                                    @if ($caleg->sts == 1)
                                    <button wire:click="lawan({{ $caleg->id }})"
                                        class="btn btn-sm btn-success">Didukung</button>
                                    @else 
                                    <button wire:click="dukung({{ $caleg->id }})"
                                        class="btn btn-sm btn-danger">Lawan</button>
                                    @endif
                                </td>
                                <td>{{ $caleg->dapil }}</td>
                                <td>
                                    <button wire:click="edit({{ $caleg->id }})" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                    <button wire:click="delete({{ $caleg->id }})"
                                        class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $calegs->links() }}

            </div>
        </div>
    </div>


    <div class="modal " tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"
        style="{{ $isModalOpen ? 'display: block;' : '' }}" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $calegId ? 'Edit Post' : 'Tambah Post' }}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input wire:model="name" type="text" class="form-control">
                                @error('name')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="partai">Partai</label>
                                <select id="partai" wire:model="partai" class="form-control" name="partai">
                                    <option value= "">-- pilih partai --</option>
                                    @foreach ($listPartai as $lt)
                                        <option value="{{ $lt->id }}">{{ $lt->no_partai}}. {{ $lt->nama_partai}}</option>
                                    @endforeach
                                </select>
                                @error('partai')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="noUrut">No Urut</label>
                                <input wire:model="noUrut" type="text" class="form-control">
                                @error('noUrut')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="sts">Status</label>
                                <input wire:model="sts" type="text" class="form-control">
                                @error('sts')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="dapil">Dapil</label>
                                <select id="dapil" wire:model="dapil" class="form-control" name="dapil">
                                    <option value="" selected>-- pilih dapil --</option>
                                    <option value="DAPIL 1">DAPIL 1</option>
                                    <option value="DAPIL 2">DAPIL 2</option>
                                    <option value="DAPIL 3">DAPIL 3</option>
                                </select>
                                @error('dapil')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button wire:click="closeModal" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Batal</button>
                    <button wire:click="{{ $calegId ? 'update' : 'create' }}" type="button"
                        class="btn btn-primary">{{ $calegId ? 'Perbarui' : 'Tambah' }}</button>
                </div>
            </div>
        </div>
    </div>
</div>
