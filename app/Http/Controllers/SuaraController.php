<?php

namespace App\Http\Controllers;

use App\Models\Tps;
use App\Models\Caleg;
use App\Models\Suara;
use App\Models\Partai;
use Illuminate\Http\Request;

class SuaraController extends Controller
{
    public function index()
    {
        return view('suara.index');
    }

    public function hitung(Request $request)
    {
        $partai = Partai::all();
        $tps = Tps::all();
        
        $jmlSuara = "";

        $persentasiSuara = "";

        $persentasiSuaraTPS = "";

        $persentasiSuara .= "<div class='col-3' style='margin: 0 auto;'>
                                <h4 class='text-center'>Suara Terkumpul : ".number_format((\App\Models\Suara::count() / (\App\Models\Tps::count() * 77))*100, 2)."%</h4>
                                <div class='progress'>
                                    <div class='progress-bar' role='progressbar' style='width: ".number_format((\App\Models\Suara::count() / (\App\Models\Tps::count() * 77))*100, 2)."%' aria-valuenow='0' aria-valuemin='0' aria-valuemax='100'></div>
                                </div>
                            </div>";

        foreach ($tps as $t) {
            $persen = number_format((\App\Models\Suara::where('tps_id', $t->id)->count() / 77) * 100,2);
            if ($persen > 0) {
                $persentasiSuaraTPS .= "TPS ".$t->name." ".$t->kelurahan." ".$persen."% |
                "; 
            }
            
        }

        foreach ($partai as $p) {

            $calegByPartai = Caleg::where('partai_id', $p->id)->get();

            if(count($calegByPartai) > 0){
                $jmlSuara .= "<div class='col-sm-12 col-md-3 col-lg-2'> <table class='table table-striped table-hover'>
                            <tr>
                                <td ><h6>$p->no_partai. $p->nama_partai</h6></td>
                                <td class='text-center' style='font-weight: bold !important'><h6>".number_format(\App\Models\Suara::where('caleg_id', 0)->where('partai_id', $p->no_partai)->sum('jumlah'),0, '', '.')  ."</h6></td>
                            </tr>
                            ";
                            foreach ($calegByPartai as $c){
                                $jmlSuara .= "<tr>";
    
                                $jmlSuara .= "<td style='font-size: 12px;'>".$c->no_urut.". ".  substr($c->name,0,15)."</td>
                                <td class='text-center' style='font-weight: bold'>". number_format(\App\Models\Suara::where('caleg_id', $c->id)->sum('jumlah'), 0, '', '.')  ."</td>";
                                   
                                    
                                $jmlSuara .= "</tr>";
                            }
    
                $jmlSuara .= "<tr>
                            <td style='text-align: right;'>Jumlah </td>
                            <td  class='text-center' style='font-weight: bold'>". number_format(\App\Models\Suara::where('partai_id', $p->id)->sum('jumlah'),0,'','.') ."</td>
                        </tr>";
                $jmlSuara .= "</table>
                        </div>";
            }

        }
        
        $data = [
            'jmlSuara' => $jmlSuara,
            'persentasiSuara' => $persentasiSuara,
            'persentasiSuaraTPS' => $persentasiSuaraTPS
        ];
        
        return response()->json([
            'status' => true,
            'message' => 'berhasil',
            'html' => $data
        ]);
    }
    
    public function input_suara()
    {
        return view('suara.input');
    }
}
