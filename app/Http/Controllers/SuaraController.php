<?php

namespace App\Http\Controllers;

use App\Models\Caleg;
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
        $data = "";

        foreach ($partai as $p) {

            $calegByPartai = Caleg::where('partai_id', $p->id)->get();

            if(count($calegByPartai) > 0){
                $data .= "<div class='col-sm-12 col-md-3 col-lg-2'> <table class='table table-striped table-hover'>
                            <tr>
                                <td ><h6>$p->no_partai. $p->nama_partai</h6></td>
                                <td class='text-center' style='font-weight: bold !important'><h6>".\App\Models\Suara::where('caleg_id', 0)->where('partai_id', $p->no_partai)->sum('jumlah')  ."</h6></td>
                            </tr>
                            ";
                            foreach ($calegByPartai as $c){
                                $data .= "<tr>";
    
                                $data .= "<td style='font-size: 12px;'>".$c->no_urut.". ".  substr($c->name,0,15)."</td>
                                <td class='text-center' style='font-weight: bold'>". \App\Models\Suara::where('caleg_id', $c->id)->sum('jumlah')  ."</td>";
                                   
                                    
                                $data .= "</tr>";
                            }
    
                $data .= "<tr>
                            <td style='text-align: right;'>Jumlah </td>
                            <td  class='text-center' style='font-weight: bold'>". \App\Models\Suara::where('partai_id', $p->id)->sum('jumlah')  ."</td>
                        </tr>";
                $data .= "</table>
                        </div>";
            }

        }
        
        
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
