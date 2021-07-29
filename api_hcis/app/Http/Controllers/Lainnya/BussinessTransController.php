<?php

namespace App\Http\Controllers\Lainnya;

use Validator;

use App\Models\BussinessTrans;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Database\QueryException;

class BussinessTransController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page']);

        $get = BussinessTrans::getBussinessTrans($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'kode_bussiness_trans' => $request->post('kode_bussiness_trans'),
                'nama_bussiness_trans' => strtoupper($request->post('nama_bussiness_trans')),
            ];
            // insert
            BussinessTrans::create($allowPost);

            $response = [
                'status_code' => 201,
                'message'     => 'data telah ditambahkan',
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage(),
            ];
        } catch (QueryException $Error) {
            $response = [
                'status_code' => 400,
                'message'     => $Error->getMessage(),
            ];
        } finally {
            return response()->json($response);
        }
    }
    public function delete($id)
    {
        try {

            BussinessTrans::findOrFail($id)->delete();
            $response = [
                'status_code' => 200,
                'message'     => 'data telah dihapus',
            ];
        } catch (\Illuminate\Database\QueryException $error) {
            $response = [
                'status_code' => 400,
                'message'     => 'Sedang terjadi kesalahan, silahkan coba beberapa saat lagi',
            ];
        } catch (\Exception $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage(),
            ];
        } finally {
            return response()->json($response);
        }
    }

    public function update($id, Request $request)
    {
        try {

            // set tules
            // $this->rules($request);

            $old = BussinessTrans::findOrFail($id);
            $kode = !empty($request->post('kode_bussiness_trans')) ? $request->post('kode_bussiness_trans') : $old->kode_bussiness_trans;
            $nama = !empty($request->post('nama_bussiness_trans')) ? $request->post('nama_bussiness_trans') : $old->nama_bussiness_trans;

            $old->update([
                'kode_bussiness_trans'    => $kode,
                'nama_bussiness_trans'    => strtoupper($nama)
            ]);
            $response = [
                'status_code' => 200,
                'message'     => 'Data telah diperbarui',
                'response'    => $old,
            ];
        } catch (QueryException $Error) {
            $response = [
                'status_code' => 400,
                'message'     => $Error->getMessage(),

            ];
        } catch (\Exception $Error) {
            $response = [
                'status_code' => 400,
                'message'     => $Error->getMessage(),
            ];
        } finally {
            return response()->json($response);
        }
    }


    public function multipleDelete(Request $request)
    {
        try {
            $listIdBussinessTrans = json_decode($request->post('id_bussiness_trans'), true);

            if (!is_array($listIdBussinessTrans) || count($listIdBussinessTrans) <= 0)
                throw new \Exception('bussiness trans tidak ditemukan');

            BussinessTrans::whereIn('id', $listIdBussinessTrans)->delete();
            $response = [
                'status_code' => 200,
                'message'     => 'data telah dihapus',
            ];
        } catch (\Illuminate\Database\QueryException $error) {
            $response = [
                'status_code' => 400,
                'message'     => 'Sedang terjadi kesalahan, silahkan coba beberapa saat lagi',
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage(),
            ];
        } finally {
            return response()->json($response);
        }
    }
}


trait Rules
{
    private $message = [
        'required'      => ':attribute harus diisi',
        'nama_bussiness_trans.max'      => 'kolom nama maksimal 100 karakter',
        'kode_bussiness_trans.max'      => 'kolom kode maksimal 50 karakter',

    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'kode_bussiness_trans'  => 'required|max:50',
            'nama_bussiness_trans'  => 'required|max:100',
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
