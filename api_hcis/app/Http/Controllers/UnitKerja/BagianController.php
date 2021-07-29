<?php

namespace App\Http\Controllers\UnitKerja;

use Validator;

use App\Models\UnitKerjaBagian;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Database\QueryException;

class BagianController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page', 'id_unit_kerja_divisi']);

        $get = UnitKerjaBagian::getUnitKerjaBagian($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'id_unit_kerja_divisi' => $request->post('id_unit_kerja_divisi'),
                'kode_bagian'          => $request->post('kode_bagian'),
                'nama_bagian'          => strtoupper($request->post('nama_bagian')),
            ];
            // insert
            UnitKerjaBagian::create($allowPost);

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

            UnitKerjaBagian::findOrFail($id)->delete();
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
            $listIdBagian = json_decode($request->post('id_bagian'), true);

            if (!is_array($listIdBagian) || count($listIdBagian) <= 0)
                throw new \Exception('Unit Bagian tidak ditemukan');

            UnitKerjaBagian::whereIn('id', $listIdBagian)->delete();
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

            $old = UnitKerjaBagian::findOrFail($id);
            $kodeBagian = !empty($request->post('kode_bagian')) ? $request->post('kode_bagian') : $old->kode_bagian;
            $nama = !empty($request->post('nama_bagian')) ? $request->post('nama_bagian') : $old->nama_bagian;


            $old->update([
                'id_unit_kerja_divisi'  => $request->post('id_unit_kerja_divisi') ?? $old->id_unit_kerja_divisi,
                'kode_bagian'           => $kodeBagian,
                'nama_bagian'           => strtoupper($nama),
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
        'required'                  => ':attribute harus diisi',
        'nama_bagian.max'           => 'kolom nama bagian maksimal 100 karakter',
        'id_unit_kerja_divisi.max'  => 'kepala unit kerja melebihi 10 karatker'
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'id_unit_kerja_divisi'  => 'required|max:10',
            'nama_bagian'           => 'required|max:100',
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
