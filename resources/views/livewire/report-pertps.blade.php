<div class="container">
    <div class="row my-3">
        <div class="col-md-12">
            <h3 class="text-center">Laporan Perhitungan Target Suara Per TPS</h3>
        </div>
    </div>

    @foreach ($kelurahan as $kel)
        <div class="row my-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <strong>KEL. {{ $kel->nama_kelurahan }}</strong> KEC. {{ $kel->kecamatan->nama_kecamatan }}
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

                                    @php
                                        $pendukung = \App\Models\Pendukung::join('dpts', 'pendukungs.dpt_id', '=', 'dpts.id')
                                            ->where('dpts.kelurahan', $kel->nama_kelurahan)
                                            ->groupBy('tps')
                                            ->select('tps', \DB::raw('COUNT(*) as total_pendukung'))
                                            ->get();
                                    @endphp
                                    @foreach ($pendukung as $item)
                                        <tr>
                                            <td>TPS {{ $item->tps }}</td>
                                            <td>{{ $item->total_pendukung }}</td>
                                            <td>{{ \App\Models\Dpt::where('kelurahan', $kel->nama_kelurahan)->where('tps', $item->tps)->count() }}</td>
                                            <td> {{ number_format((($item->total_pendukung / \App\Models\Dpt::where('kelurahan', $kel->nama_kelurahan)->where('tps', $item->tps)->count()) * 100),2 )}} % </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach

</div>
