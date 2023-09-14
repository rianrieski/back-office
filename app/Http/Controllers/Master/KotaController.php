<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\Kota;
use Illuminate\Http\Request;

class KotaController extends Controller
{
    public function getKota (Request $request){
        $kota = Kota::where('propinsi_id',$request->propinsi_id)->get();
        return response()->json($kota);
    }
}
