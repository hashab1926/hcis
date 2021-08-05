<?php

namespace App\Http\Controllers;

use App\Models\BuktiFbcj;
use Illuminate\Http\Request;

class BuktiFbcjController extends Controller
{
    public function index($idFbcj, Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page', 'id_pengajuan']);

        $get = BuktiFbcj::getLampiran($idFbcj, $allowGet);
        return response()->json($get);
    }
}
