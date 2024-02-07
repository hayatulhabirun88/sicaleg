<?php

namespace App\Http\Controllers;

use App\Models\Dpt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use PhpOffice\PhpSpreadsheet\IOFactory;

class ImportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (Auth::user()->level != "admin") {
            return redirect()->to('/');
        }

        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);

        // Get the uploaded file
        $file = $request->file('file');

        // Baca file Excel menggunakan PhpSpreadsheet
        $spreadsheet = IOFactory::load($file->getPathname());
        $worksheet = $spreadsheet->getActiveSheet();
        
        
        // Retrieve data from the worksheet
        $data = $worksheet->toArray();

        foreach ($data as $row) {

            $nik            = $row[0];
            $nama           = $row[1];
            $alamat         = $row[2];
            $kelurahan      = $row[3];
            $kecamatan      = $row[4];
            $rt             = $row[5];
            $rw             = $row[6];
            $jenis_kelamin  = $row[7];
            $tgl_lahir      = $row[8];
            $umur           = $row[9];
            $tps            = $row[10];

            $data = [
                'nama' => $nama,
                'umur' => $umur,
                'jenis_kelamin' => $jenis_kelamin,
                'nik' => $nik,
                'no_kk' => '',
                'kecamatan' => $kecamatan,
                'kelurahan' => $kelurahan,
                'rt' => $rt,
                'rw' => $rw,
                'tps' => $tps,
                'dukungan' => '',
                'alamat' => $alamat,
                'tgl_lahir' => $tgl_lahir,
                'foto' => '',
            ];
            
            Dpt::create($data);


        }

        return redirect()->to('get-import')->with('success', 'Data berhasil di import');
    }

    public function show()
    {
        if (Auth::user()->level != "admin") {
            return redirect()->to('/');
        }
        $laki2 = Dpt::where('jenis_kelamin', 'L')->count();
        $perempuan = Dpt::where('jenis_kelamin', 'P')->count();
        $total = Dpt::count();
        $kecamatan = Dpt::select('kecamatan', DB::raw('COUNT(*) AS jumlah'))
        ->groupBy('kecamatan')
        ->get();

        return view('import.show', compact(['laki2','perempuan', 'total','kecamatan']));
    }
}
