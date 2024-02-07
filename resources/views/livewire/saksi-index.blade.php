<div class="container">
    <h1 class="text-center">SAKSI</h1>
    <div class="row">
        <div class="col-md-3">
            <button wire:click="tambahSaksi()" class="btn btn-sm btn-primary">Tambah</button>
        </div>
        <div class="col-md-5">
            <table class="table table-light" style="font-weight: bold">
                <tbody>

                </tbody>
                
            </table>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Aksi</th>
                            <th>Nama Lengkap</th>
                            <th>Alamat</th>
                            <th>No HP</th>
                            <th>TPS</th>
                            <th>Kelurahan</th>
                            <th>Kecamatan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($saksi as $index => $s)
                        <tr>
                            <td>{{$index + $saksi->firstItem()}}</td>
                            <td>
                                <button wire:click="edit({{ $s->id }})" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button wire:click="delete({{ $s->id }})"
                                    class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </td>
                            <td>{{$s->nama_lengkap}}</td>
                            <td>{{$s->alamat}}</td>
                            <td>{{$s->no_hp}}</td>
                            <td>{{$s->saksi->name}}</td>
                            <td>{{$s->saksi->kelurahan}}</td>
                            <td>{{$s->saksi->kecamatan}}</td>
                            <td>
                                @if ($s->status == "Aktif")
                                <button wire:click="tidakAktif({{ $s->id }})"
                                    class="btn btn-sm btn-success">Aktif</button>
                                @else 
                                <button wire:click="aktif({{ $s->id }})"
                                    class="btn btn-sm btn-danger">Tidak Aktif</button>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $saksi->links() }}

            </div>
        </div>
    </div>

    <div class="modal " tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"
    style="{{ $isModalOpen ? 'display: block;' : '' }}" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $saksiId ? 'Edit Post' : 'Tambah Post' }}</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="name">Nama Lengkap</label>
                            <input wire:model="name" type="text" class="form-control" placeholder="Masukan nama lengkap">
                            @error('name')
                                <span class="error" style="color:red" >{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input wire:model="alamat" type="text" class="form-control" placeholder="Masukan alamat">
                            @error('alamat')
                                <span class="error" style="color:red" >{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="no_hp">No HP</label>
                            <input wire:model="no_hp" type="text" class="form-control" placeholder="Masukan No HP">
                            @error('no_hp')
                                <span class="error" style="color:red" >{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="tpsId">TPS</label>
                            <select id="tpsId" wire:model="tpsId" class="form-control" name="tpsId">
                                <option value="">-- Pilih TPS --</option>
                                @foreach($listTps as $lt)
                                    @if(\App\Models\Saksi::where('tps_id', $lt->id)->count() == 0 )
                                    <option value="{{ $lt->id }}">TPS {{ $lt->name }} {{ $lt->kelurahan }} {{ $lt->kecamatan }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('tpsId')
                                <span class="error" style="color:red" >{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="statusSaksi"> Status</label>
                            <div class="form-check">
                                <input class="form-check-input" wire:model="statusSaksi" type="checkbox" value="statusSaksi" id="status" {{ $statusSaksi == "Aktif" ? "checked" : ""}}/>
                                <label class="form-check-label" for="status"> Aktif </label>
                            </div>
                            @error('statusSaksi')
                                <span class="error" style="color:red" >{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="closeModal" type="button" class="btn btn-secondary"
                    data-dismiss="modal">Batal</button>
                <button wire:click="{{ $saksiId ? 'update' : 'create' }}" type="button"
                    class="btn btn-primary">{{ $saksiId ? 'Perbarui' : 'Tambah' }}</button>
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