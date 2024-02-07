<div class="container">
    <h1 class="text-center">TPS</h1>
    <div class="row">
        <div class="col-md-3">
            <button wire:click="openModal()" class="btn btn-sm btn-primary">Tambah</button>
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
                            <th>Nama TPS</th>
                            <th>Kelurahan</th>
                            <th>Kecamatan</th>
                            <th style="text-align:center;">Suara Terkumpul %</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($tps as $index => $s)
                        <tr>
                            <td>{{$index + $tps->firstItem()}}</td>
                            <td>
                                <button wire:click="edit({{ $s->id }})" class="btn btn-sm btn-primary"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button wire:click="delete({{ $s->id }})"
                                    class="btn btn-sm btn-danger"><i class="fa-solid fa-trash"></i></button>
                            </td>
                            <td>{{$s->name}}</td>
                            <td>{{$s->kelurahan}}</td>
                            <td>{{$s->kecamatan}}</td>
                            <td style="text-align:center;">
                                {{number_format((\App\Models\Suara::where('tps_id', $s->id)->count() / 77)*100, 2) }} %
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{(\App\Models\Suara::where('tps_id', $s->id)->count() / 77)*100 }}%" aria-valuenow="{{(\App\Models\Suara::where('tps_id', $s->id)->count() / 77)*100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                {{ $tps->links() }}

            </div>
        </div>
    </div>

    <div class="modal " tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"
    style="{{ $isModalOpen ? 'display: block;' : '' }}" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $tpsId ? 'Edit Post' : 'Tambah Post' }}</h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="namaTps">Nama TPS</label>
                            <input wire:model="namaTps" type="text" class="form-control" placeholder="Masukan nama lengkap">
                            @error('namaTps')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="kelurahan">Kelurahan</label>
                            <select wire:model="kelurahan" id="kelurahan" class="form-control" name="kelurahan">
                                <option value="" >-- Pilih Kelurahan --</option>
                                <option value="BURANGASI" {{ $kelurahan == "BURANGASI" ? "selected" : ""}}>BURANGASI</option>
                                <option value="BURANGASI RUMBIA" {{ $kelurahan == "BURANGASI RUMBIA" ? "selected" : ""}}>BURANGASI RUMBIA</option>
                                <option value="LAPANDEWA MAKMUR" {{ $kelurahan == "LAPANDEWA MAKMUR" ? "selected" : ""}}>LAPANDEWA MAKMUR</option>
                                <option value="LAPANDEWA KAIDEA" {{ $kelurahan == "LAPANDEWA KAIDEA" ? "selected" : ""}}>LAPANDEWA KAIDEA</option>
                                <option value="LAPANDEWA JAYA" {{ $kelurahan == "LAPANDEWA JAYA" ? "selected" : ""}}>LAPANDEWA JAYA</option>
                                <option value="LAPANDEWA" {{ $kelurahan == "LAPANDEWA" ? "selected" : ""}}>LAPANDEWA</option>
                            </select>
                            @error('kelurahan')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="kecamatan">Kecamatan</label>
                            <select wire:model="kecamatan" id="kecamatan" class="form-control" name="kecamatan">
                                <option value="">-- Pilih Kecamatan --</option>
                                <option value="LAPANDEWA" {{$kecamatan == "LAPANDEWA" ? "selected" : ""}}>LAPANDEWA</option>
                                <option value="BATU ATAS" {{$kecamatan == "BATU ATAS" ? "selected" : ""}} >BATU ATAS</option>
                            </select>
                            @error('kecamatan')
                                <span class="error">{{ $message }}</span>
                            @enderror
                        </div>

                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button wire:click="closeModal" type="button" class="btn btn-secondary"
                    data-dismiss="modal">Batal</button>
                <button wire:click="{{ $tpsId ? 'update' : 'create' }}" type="button"
                    class="btn btn-primary">{{ $tpsId ? 'Perbarui' : 'Tambah' }}</button>
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