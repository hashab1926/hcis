<?php

namespace App\Http\Controllers\UnitKerja;

use Validator;

use App\Models\UnitKerjaKepala;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Database\QueryException;

class KepalaController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page']);

        $get = UnitKerjaKepala::getUnitKerjaKepala($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'kode_kepala' => strtoupper($request->post('kode_kepala')),
                'nama_kepala' => strtoupper($request->post('nama_kepala')),

            ];
            // insert
            UnitKerjaKepala::create($allowPost);

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

            UnitKerjaKepala::findOrFail($id)->delete();
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

    public function multipleDelete(Request $request)
    {
        try {
            $listIdKepala = json_decode($request->post('id_kepala'), true);

            if (!is_array($listIdKepala) || count($listIdKepala) <= 0)
                throw new \Exception('Karyawan tidak ditemukan');

            UnitKerjaKepala::whereIn('id', $listIdKepala)->delete();
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

    public function update($id, Request $request)
    {
        try {

            // set tules
            // $this->rules($request);

            $old = UnitKerjaKepala::findOrFail($id);
            $kodeKepala = !empty($request->post('kode_kepala')) ? $request->post('kode_kepala') : $old->kode_kepala;
            $nama = !empty($request->post('nama_kepala')) ? $request->post('nama_kepala') : $old->nama_kepala;

            $old->update([
                'kode_kepala'    => strtoupper($kodeKepala),
                'nama_kepala'    => strtoupper($nama),
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
}


trait Rules
{
    private $message = [
        'required'             => ':attribute harus diisi',
        'nama_kepala.max'      => 'kolom nama kepala maksimal 100 karakter',
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'nama_kepala'  => 'required|max:100',
            'kode_kepala'  => 'required|max:20'
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
