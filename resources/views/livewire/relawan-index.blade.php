<div class="container">
    <h1 class="text-center">DAFTAR PEMILIH TETAP</h1>
    <div class="row mt-3">
        <div class="col-md-3">
            <input type="text" wire:model="searchNama" name="searchNama" placeholder="Cari Nama" class="form-control">
        </div>
        <div class="col-md-3">
            <input type="text" wire:model="searchUmur" name="searchUmur" placeholder="Cari Umur"
                class="form-control">
        </div>
        <div class="col-md-3">
            <input type="text" wire:model="searchJk" name="searchJk" placeholder="Cari Jenis Kelamin"
                class="form-control">
        </div>
        <div class="col-md-3">
            <input type="text" wire:model="searchKelurahan" name="searchKelurahan" placeholder="Cari Kelurahan"
                class="form-control">
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-12">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Aksi</th>
                            <th>Dukungan</th>
                            <th>Nama</th>
                            <th>JK</th>
                            <th>Umur</th>
                            <th>Kelurahan</th>
                            <th>Kecamatan</th>
                            <th>TPS</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @php
                            $i = 0;
                            
                        @endphp
                        @foreach ($dpts as $index => $dpt)
                            @php
                                $datapendukung = \App\Models\Pendukung::where('dpt_id', $dpt->id)->get();
                                $badge = ['success', 'info', 'warning', 'success', 'primary', 'info', 'warning', 'success', 'primary', 'info', 'warning', 'success', 'primary', 'info', 'warning', 'success', 'primary', 'info', 'warning', 'success', 'primary', 'info', 'warning', 'success', 'primary', 'info', 'warning', 'success', 'primary', 'info', 'warning', 'success', 'primary', 'info', 'warning', 'success', 'primary', 'info', 'warning', 'success'];
                                $d = 0;
                            @endphp
                            <tr>

                                <td>
                                    <button wire:click="tambahDukungan({{ $dpt->id }})"
                                        class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Tambahkan Dukungan"> <i class="fa-solid fa-plus"></i></button>
                                </td>

                                    <td>
                                        @if (count($datapendukung) > 0)
                                            @foreach ($datapendukung as $item)
                                                <button data-bs-toggle="tooltip" data-bs-placement="top"
                                                    title="Hapus dukungan dengan relawan {{ \App\Models\User::find($item->user_id)->name ?? ' yang belum ada' }} ?"
                                                    style="border:none;"
                                                    class="badge rounded-pill bg-{{ $badge[$d++] }}"
                                                    wire:click="hapusPendukung({{ $item->id }})">
                                                    {{ mb_strimwidth(\App\Models\Caleg::find($item->caleg_id)->name, 0, 10, '...') }}

                                                </button><br>
                                            @endforeach
                                        @else
                                            <span class="badge rounded-pill bg-danger">Belum ada</span><br>
                                        @endif

                                    </td>
                                <td>{{ $dpt->nama }}</td>
                                <td>{{ $dpt->jenis_kelamin }}</td>
                                <td>{{ $dpt->umur }}</td>
                                <td>{{ $dpt->kelurahan }}</td>
                                <td>{{ $dpt->kecamatan }}</td>
                                <td>{{ $dpt->tps }}</td>


                            </tr>
                        @endforeach --}}

                        @foreach ($dpt as $dt)
                            <tr>
                                <td>
                                    <button wire:click="tambahDukungan({{ $dt->id }})"
                                        class="btn btn-sm btn-primary" data-bs-toggle="tooltip" data-bs-placement="top"
                                        title="Tambahkan Dukungan"> <i class="fa-solid fa-plus"></i></button>
                                </td>
                                <td>
                                    @php
                                        $item = \App\Models\Pendukung::where('dpt_id', $dt->id)
                                            ->where('user_id', Auth::user()->id)
                                            ->first();
                                    @endphp
                                    @if ($item !== null)
                                        <button style="border:none;" class="badge rounded-pill bg-success"
                                            wire:click="hapusPendukung({{ $item->id }})">
                                            {{ mb_strimwidth(\App\Models\Caleg::find($item->caleg_id)->name, 0, 10, '...') }}
                                        </button><br>
                                    @else
                                        <span class="badge rounded-pill bg-danger">Belum ada</span><br>
                                    @endif

                                </td>
                                <td>{{ $dt->nama }}</td>
                                <td>{{ $dt->jenis_kelamin }}</td>
                                <td>{{ $dt->umur }}</td>
                                <td>{{ $dt->kelurahan }}</td>
                                <td>{{ $dt->kecamatan }}</td>
                                <td>{{ $dt->tps }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>


                {{ $dpt->links() }}

                {{-- @if ($dpts)
                    {{ $dpts->links() }}
                @else
                    <h3 style="color:red" class="text-center">Anda belum mendaftarkan wilayah DAPIL. Silahkan hubungi
                        administrator !</h3>
                @endif --}}

            </div>
        </div>
    </div>

    <div class="modal " tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"
        style="{{ $isModalOpen ? 'display: block;' : '' }}" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $dptId ? 'Edit Post' : 'Tambah Post' }}</h5>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="nama">Nama</label>
                                <input wire:model="nama" type="text" class="form-control">
                                @error('nama')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="nik">NIK</label>
                                <input wire:model="nik" type="text" class="form-control">
                                @error('nik')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="no_kk">No KK</label>
                                <input wire:model="noKk" type="text" class="form-control">
                                @error('noKk')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="umur">Umur</label>
                                <input wire:model="umur" type="text" class="form-control">
                                @error('umur')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="jenis_kelamin">jenis_kelamin</label>
                                <input wire:model="jenisKelamin" type="text" class="form-control">
                                @error('jenisKelamin')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kelurahan">Kelurahan</label>
                                <input wire:model="kelurahan" type="text" class="form-control">
                                @error('kelurahan')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="kecamatan">Kecamatan</label>
                                <input wire:model="kecamatan" type="text" class="form-control">
                                @error('kecamatan')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6">

                            <div class="form-group">
                                <label for="rt">RT</label>
                                <input wire:model="rt" type="text" class="form-control">
                                @error('rt')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rw">RW</label>
                                <input wire:model="rw" type="text" class="form-control">
                                @error('rw')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="rw">RW</label>
                                <input wire:model="rw" type="text" class="form-control">
                                @error('rw')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="tps">TPS</label>
                                <input wire:model="tps" type="text" class="form-control">
                                @error('tps')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="dukungan">Dukungan</label>
                                <input wire:model="dukungan" type="text" class="form-control">
                                @error('dukungan')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>


                            <div class="form-group">
                                <label for="tgl_lahir">Tanggal Lahir</label>
                                <input wire:model="tglLahir" type="text" class="form-control">
                                @error('tglLahir')
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

                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <div class="form-group">
                                    <label for="alamat">Alamat</label>
                                    <textarea id="alamat" class="form-control" wire:model="alamat" rows="3"></textarea>
                                </div>
                                @error('alamat')
                                    <span class="error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button wire:click="closeModal" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Batal</button>
                    <button wire:click="{{ $dptId ? 'update' : 'create' }}" type="button"
                        class="btn btn-primary">{{ $dptId ? 'Perbarui' : 'Tambah' }}</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal " tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false"
        style="{{ $isModalOpenCaleg ? 'display: block;' : '' }}" aria-labelledby="staticBackdropLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Dukungan</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        Caleg
                        <select id="caleg" wire:model="caleg" class="form-control" name="caleg"
                            style="display: inline-block">
                            <option value="">-- Pilih Caleg --</option>
                            @if ($calegByDapil)
                                @foreach ($calegByDapil as $caleg)
                                    <option value="{{ $caleg->id }}">{{ $caleg->name }}</option>
                                @endforeach
                            @endif
                        </select>
                        @error('caleg')
                            <span class="error">{{ $message }}</span>
                        @enderror
                    </div>

                </div>
                <div class="modal-footer">
                    <button wire:click="closeModal" type="button" class="btn btn-secondary"
                        data-dismiss="modal">Batal</button>
                    <button wire:click="updateDukungan()" type="button" class="btn btn-primary">Tambah</button>
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
