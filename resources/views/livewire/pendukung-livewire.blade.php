<div class="container">
    <h1 class="text-center">DAFTAR PENDUKUNG</h1>
    <div class="row">
        <div class="col-md-3">
            <input type="text" wire:model="searchNama" name="searchNama" placeholder="Cari Nama" class="form-control">
        </div>
        <div class="col-md-5">
            <table class="table table-light" style="font-weight: bold">
                <tbody>
                    <tr>
                        <td>Laki-laki</td>
                        <td>:</td>
                        <td>{{ $laki2 }}</td>
                        <td>Perempuan</td>
                        <td>:</td>
                        <td>{{ $perempuan }}</td>
                        <td>Total</td>
                        <td>:</td>
                        <td>{{ $total }}</td>
                        <td></td>
                        <td></td>
                    </tr>
                </tbody>
                
            </table>
            
        </div>
        @if (auth()->user()->level == "admin")
        <div class="col-md-4">
            <a href="{{asset('/')}}export-pendukung" class="btn btn-success">Export</a>
            <button wire:click= "tambahPendukung()" class="btn btn-primary">Tambah</button>
        </div>
        @endif
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Aksi</td>
                            <td>Nama</td>
                            <td>Umur</td>
                            <td>Jenis Kelamin</td>
                            <td>Kelurahan</td>
                            <td>Kecamatan</td>
                            <td>Relawan</td>
                            <td>Dukungan</td>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i = 1;
                        @endphp
                        @foreach ($pendukungs as $index => $pendukung)
                            <tr>
                                <td>{{ $index + $pendukungs->firstItem() }}</td>
                                <td>
                                    @if (Auth::user()->level == 'admin')
                                        <button wire:click="edit({{ $pendukung->id }})"
                                            class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                    @endif
                                    <button wire:click="delete({{ $pendukung->id }})" class="btn btn-sm btn-danger"><i
                                            class="fa-solid fa-trash"></i></button>
                                </td>
                                <td>{{ @$pendukung->dpts->nama }}</td>
                                <td>{{ @$pendukung->dpts->umur }}</td>
                                <td>{{ @$pendukung->dpts->jenis_kelamin }}</td>
                                <td>{{ @$pendukung->dpts->kelurahan }}</td>
                                <td>{{ @$pendukung->dpts->kecamatan }}</td>
                                <td>{{ @$pendukung->user->name ?? '-' }}</td>
                                <td>{{ @$pendukung->caleg->name }}</td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $pendukungs->links() }}

            </div>
        </div>
    </div>

    <div class="modal " tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"
        style="{{ $isModalOpen ? 'display: block;' : '' }}" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $pendukungId ? 'Edit Post' : 'Tambah Post' }}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">
                            {{-- <div class="form-group">
                            Caleg
                            <select id="caleg" wire:model="calegId" class="form-control" name="caleg"
                                style="display: inline-block">
                                <option value="" >-- Pilih Caleg --</option>
                                @foreach ($calegs as $caleg)
                                    <option value="{{ $caleg->id }}">{{ $caleg->name }}</option>
                                @endforeach
                            </select>
                            @error('calegId')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div> --}}
                            @if (Auth::user()->level == 'admin')
                                <div class="form-group">
                                    Relawan
                                    <select id="relawan" wire:model="userId" class="form-control" name="relawan"
                                        style="display: inline-block">
                                        <option value="">-- Pilih Relawan --</option>
                                        @foreach ($relawans as $relawan)
                                            <option value="{{ $relawan->id }}">{{ $relawan->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('userId')
                                        <span class="error">{{ $message }}</span>
                                    @enderror
                                </div>
                            @endif

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button wire:click="closeModal" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Batal</button>
                    <button wire:click="{{ $pendukungId ? 'update' : 'create' }}" type="button"
                        class="btn btn-primary">{{ $pendukungId ? 'Perbarui' : 'Tambah' }}</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal " tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"
        style="{{ $isOpenPendukung ? 'display: block;' : '' }}" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $pendukungId ? 'Edit Pendukung' : 'Tambah Pendukung' }}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-12">

                            <div class="mb-3">
                                <label for="nik" class="form-label">NIK</label>
                                <input
                                    type="text"
                                    wire:model="nik"
                                    class="form-control"
                                    name="nik"
                                    id="nik"
                                    aria-describedby="nik"
                                    placeholder="Masukan NIK"
                                />
                                @error('nik')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="namaLengkap" class="form-label">Nama Lengkap</label>
                                <input
                                    type="text"
                                    wire:model="namaLengkap"
                                    class="form-control"
                                    name="namaLengkap"
                                    id="namaLengkap"
                                    aria-describedby="namaLengkap"
                                    placeholder="Masukan nama lengkap"
                                />
                                @error('namaLengkap')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="umur" class="form-label">Umur</label>
                                <input
                                    type="text"
                                    wire:model="umur"
                                    class="form-control"
                                    name="umur"
                                    id="umur"
                                    aria-describedby="umur"
                                    placeholder="Masukan umur"
                                />
                                @error('umur')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                Jenis Kelamin
                                <div class="form-check">
                                    <input class="form-check-input" wire:model="jenisKelamin" type="radio" name="jenis_kelamin" id="jenis_kelamin" value="L" />
                                    <label class="form-check-label" for="jenis_kelamin"> Pria </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" wire:model="jenisKelamin" type="radio" name="jenis_kelamin" id="jenis_kelamin" value="P" />
                                    <label class="form-check-label" for="jenis_kelamin"> Wanita</label>
                                </div>
                            </div>


                            <div class="mb-3">
                                <label for="kecamatan" class="form-label">Kecamatan</label>
                                <select
                                    class="form-select"
                                    name="kecamatan"
                                    id="kecamatan"
                                    wire:model="kecamatan"
                                    wire:change="getKelurahanData"
                                >   
                                    @if($selectedKecamatan)
                                        <option value=""> --pilih kecamatan--</option>
                                        @foreach($selectedKecamatan as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>

                            <div class="mb-3">
                                
                                <label for="kelurahan" class="form-label">Desa/Kelurahan</label>
                                
                                <select
                                    class="form-select"
                                    name="kelurahan"
                                    id="kelurahan"
                                    wire:model = "kelurahan"
                                >
                                    <option value=""> --pilih kelurahan--</option>
                                    @if($selectedKelurahan)
                                        @foreach($selectedKelurahan as $item)
                                            <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
                                        @endforeach
                                    @endif
                                
                                </select>
                                
                            </div>

                            <div class="mb-3">
                                <label for="tps" class="form-label">TPS</label>
                                <input
                                    type="text"
                                    wire:model="tps"
                                    class="form-control"
                                    name="tps"
                                    id="tps"
                                    aria-describedby="tps"
                                    placeholder="Masukan TPS"
                                />
                                @error('tps')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>


                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button wire:click="closeTambahPendukung()" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Batal</button>
                    <button wire:click="{{ $pendukungId ? 'update' : 'create' }}" type="button"
                        class="btn btn-primary">{{ $pendukungId ? 'Perbarui' : 'Tambah' }}</button>
                </div>
            </div>
        </div>
    </div>





    @if (session()->has('success'))
        <script>
            $(document).ready(function() {
                toastr.success("{{ session('success') }}", "Success");
            });
        </script>
    @endif
    @if (session()->has('error'))
        <script>
            $(document).ready(function() {
                toastr.error("{{ session('error') }}", "Error");
            });
        </script>
    @endif
</div>
