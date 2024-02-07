<div class="container-fluid">
    <h1 class="text-center">PERHITUNGAN SUARA</h1>
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-12">
            <div class="mb-3">
                <select
                    class="form-select form-select-lg"
                    name="tps"
                    id="tps"
                    wire:model="tps"
                >
                    <option value="">-- Pilih TPS --</option>
                    @foreach($selectTps as $stps)
                        <option value="{{ $stps->id}}">TPS {{ $stps->name}} {{ $stps->kelurahan}} </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-12">
                @if ($tps == "")
                    <h5>Suara Terkumpul {{number_format((\App\Models\Suara::count() / (\App\Models\Tps::count() * 77))*100, 2) }} %</h5>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{(\App\Models\Suara::count() / (\App\Models\Tps::count() * 77))*100 }}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                @else
                    <h5>Suara Terkumpul {{number_format((\App\Models\Suara::where('tps_id', $tps)->count() / 77)*100, 2) }} %</h5>
                    <div class="progress">
                        <div class="progress-bar" role="progressbar" style="width: {{(\App\Models\Suara::where('tps_id', $tps)->count() / 77)*100 }}%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                @endif
        </div>
    </div>
    <div class="row" >
        @foreach ($partai as $p)
            @php 
            $calegByPartai = \App\Models\Caleg::where('partai_id', $p->id)->get();
            @endphp

            @if(count($calegByPartai) > 0)
                <div class='col-sm-12 col-md-3 col-lg-2'> 
                    <table class='table table-striped table-hover'>
                        
                        <tr>
                            <td ><h6>{{$p->no_partai}}. {{$p->nama_partai}}</h6></td>
                            <td class='text-center' style='font-weight: bold !important'>
                                <div class="row">
                                    @if($tps != "")
                                    <div class="col-6">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="jumlahSuara"
                                            id="jumlahSuara"
                                            aria-describedby="helpId"
                                            wire:model = "jumlahSuara.{{$p->no_partai}}.0"
                                            value="{{\App\Models\Suara::where('caleg_id', 0)->where('partai_id', $p->no_partai)->where('tps_id', $tps)->sum('jumlah')}}"
                                            style="width:50px; padding:2px; text-align:center;"
                                        />
                                    </div>
                                    <div class="col-6">
                                        {{\App\Models\Suara::where('caleg_id', 0)->where('partai_id', $p->no_partai)->where('tps_id', $tps)->sum('jumlah')}}
                                    </div>
                                    @else
                                    <div class="col-6">
                                        <input
                                            type="text"
                                            class="form-control"
                                            name="jumlahSuara"
                                            id="jumlahSuara"
                                            aria-describedby="helpId"
                                            pattern="[0-9]"
                                            wire:model = "jumlahSuara.{{$p->no_partai}}.0"
                                            value="{{\App\Models\Suara::where('caleg_id', 0)->where('partai_id', $p->no_partai)->where('tps_id', $tps)->sum('jumlah')}}"
                                            style="width:50px; padding:2px; text-align:center;"
                                            disabled
                                        />
                                    </div>
                                    <div class="col-6">
                                        {{\App\Models\Suara::where('caleg_id', 0)->where('partai_id', $p->no_partai)->sum('jumlah')}}
                                    </div>
                                    @endif
                                    
                                    
                                </div>

                            </td>
                        </tr>
                        @foreach($calegByPartai as $key => $cp)
                            <tr>
                                <td ><h6>{{$cp->no_urut}}. {{ substr($cp->name,0,15) }}</h6></td>
                                <td class='text-center' style='font-weight: bold !important'>
                                    <div class="row">
                                        @if($tps != "")
                                            <div class="col-6">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="jumlahSuara"
                                                    id="jumlahSuara"
                                                    aria-describedby="helpId"
                                                    wire:model = "jumlahSuara.{{$p->no_partai}}.{{$cp->id}}"
                                                    placeholder=""
                                                    value="{{\App\Models\Suara::where('caleg_id', $cp->id)->where('tps_id', $tps)->sum('jumlah')}}"
                                                    style="width:50px; padding:2px; text-align:center;"
                                                />
                                            </div>
                                            <div class="col-6">
                                                {{\App\Models\Suara::where('caleg_id', $cp->id)->where('tps_id', $tps)->sum('jumlah')}}
                                            </div>
                                        @else
                                            <div class="col-6">
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="jumlahSuara"
                                                    id="jumlahSuara"
                                                    aria-describedby="helpId"
                                                    wire:model = "jumlahSuara.{{$p->no_partai}}.{{$cp->id}}"
                                                    placeholder=""
                                                    value="{{\App\Models\Suara::where('caleg_id', $cp->id)->sum('jumlah')}}"
                                                    style="width:50px; padding:2px; text-align:center;"
                                                    disabled
                                                />
                                            </div>
                                            <div class="col-6">
                                                {{\App\Models\Suara::where('caleg_id', $cp->id)->sum('jumlah')}}
                                            </div>
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                   
                </div>
                
            @endif
        @endforeach
        
    </div>
    <input type="submit" wire:click="create" value = "Submit" class="btn btn-primary"><br><br>
    @error('jumlahSuara') <p class="alert alert-danger">{{ $message }}</p> @enderror
</div>
