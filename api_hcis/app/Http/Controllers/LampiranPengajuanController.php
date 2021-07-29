<?php

namespace App\Http\Controllers;

use App\Models\LampiranPengajuan;
use Illuminate\Http\Request;

class LampiranPengajuanController extends Controller
{
    public function index($idPengajuan = null, Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page', 'id_pengajuan']);

        $get = LampiranPengajuan::getLampiran($idPengajuan, $allowGet);
        return response()->json($get);
    }
}
