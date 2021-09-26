<?php

namespace App\Http\Controllers\Lainnya;

use Validator;

use App\Models\JenisFasilitas;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Database\QueryException;

class JenisFasilitasController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page']);

        $get = JenisFasilitas::getJenisFasilitas($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'kode_fasilitas' => $request->post('kode_fasilitas'),
                'jenis_fasilitas' => strtoupper($request->post('jenis_fasilitas')),
            ];
            // insert
            JenisFasilitas::create($allowPost);

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

            JenisFasilitas::findOrFail($id)->delete();
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

            $old = JenisFasilitas::findOrFail($id);
            $kode = !empty($request->post('kode_fasilitas')) ? $request->post('kode_fasilitas') : $old->kode_fasilitas;
            $nama = !empty($request->post('jenis_fasilitas')) ? $request->post('jenis_fasilitas') : $old->jenis_fasilitas;
            $old->update([
                'kode_fasilitas'    => $kode,
                'jenis_fasilitas'    => strtoupper($nama),
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
            $listIdJenisFasilitas = json_decode($request->post('id_jenis_fasilitas'), true);

            if (!is_array($listIdJenisFasilitas) || count($listIdJenisFasilitas) <= 0)
                throw new \Exception('jenis fasilitas tidak ditemukan');

            JenisFasilitas::whereIn('id', $listIdJenisFasilitas)->delete();
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
        'jenis_fasilitas.max'      => 'kolom nama maksimal 100 karakter',
        'kode_fasilitas.max'      => 'kolom kode maksimal 50 karakter',

    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'kode_fasilitas'  => 'required|max:50',
            'jenis_fasilitas'  => 'required|max:100',
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
