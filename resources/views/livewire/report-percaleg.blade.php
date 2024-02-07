<div class="container">

    <div class="row mt-5">
        <div class="col-md-6">
            <h4>Form Laporan</h4>
            <form wire:submit.prevent="submitForm">
                <div class="form-group mb-3">
                    <select id="dapil" wire:model="dapil" class="form-control" name="dapil">
                        <option value="">-- Pilih Dapil --</option>
                        <option value="DAPIL 1">DAPIL 1</option>
                        <option value="DAPIL 2">DAPIL 2</option>
                        <option value="DAPIL 3">DAPIL 3</option>
                    </select>
                </div>
                <div class="form-group mb-3">
                    <select id="caleg" wire:model="calegs" class="form-control" name="caleg">
                        <option value="">-- Pilih Caleg --</option>
                        @if ($calegName)
                            @foreach ($calegName as $c)
                                <option value="{{ $c->id }}">{{ $c->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <input type="submit" value="proses" class="btn btn-primary">
                <input type="submit" onclick="location.reload()" value="reset" class="btn btn-secondary">
            </form>
        </div>
        <div class="col-md-6">
            <h4 class="text-center">{{ $calegNameView ?? 'NAMA CALEG' }}</h4>
            <table class="table table-light">
                <tbody>
                    <tr>
                        <td>Laki-laki</td>
                        <td>:</td>
                        <td>{{ $laki2 }} Suara</td>
                    </tr>
                    <tr>
                        <td>Perempuan</td>
                        <td>:</td>
                        <td>{{ $perempuan }} Suara</td>
                    </tr>
                    <tr>
                        <td>Total</td>
                        <td>:</td>
                        <td>{{ $laki2 + $perempuan }} Suara</td>
                    </tr>
                    <tr>
                        <td>Target</td>
                        <td>:</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            @foreach ($newResult as $caleg)
                <div class="card">
                    <div class="card-header">
                        <strong>KEL. {{ $caleg['kelurahan'] }}</strong> KEC. {{ $caleg['kecamatan'] }}
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>TPS</th>
                                        <th>SUARA</th>
                                        <th>TARGET</th>
                                        <th>PERSENTASI</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($caleg['data'] as $item)
                                        <tr>
                                            <td>TPS {{ $item['tps'] }}</td>
                                            <td>{{ $item['total_dukungan'] }}</td>
                                            <td>{{ \App\Models\Dpt::where('kelurahan', $caleg['kelurahan'])->where('tps', $item['tps'])->count() }}
                                            </td>
                                            <td> {{ number_format(($item['total_dukungan'] /\App\Models\Dpt::where('kelurahan', $caleg['kelurahan'])->where('tps', $item['tps'])->count()) *100,2) }}
                                                % <br>

                                                <div class="progress">
                                                    <div class="progress-bar" role="progressbar" style="width: {{ number_format(($item['total_dukungan'] /\App\Models\Dpt::where('kelurahan', $caleg['kelurahan'])->where('tps', $item['tps'])->count()) *100,2) }}%"
                                                        aria-valuenow="{{ number_format(($item['total_dukungan'] /\App\Models\Dpt::where('kelurahan', $caleg['kelurahan'])->where('tps', $item['tps'])->count()) *100,2) }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>

                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
