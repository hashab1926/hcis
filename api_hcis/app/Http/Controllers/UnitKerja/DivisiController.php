<?php

namespace App\Http\Controllers\UnitKerja;

use Validator;

use App\Models\UnitKerjaDivisi;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Database\QueryException;

class DivisiController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page', 'id_unit_kerja_kepala']);

        $get = UnitKerjaDivisi::getUnitKerjaDivisi($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'id_unit_kerja_kepala' => $request->post('id_unit_kerja_kepala'),
                'kode_divisi'          => strtoupper($request->post('kode_divisi')),
                'singkatan'            => strtoupper($request->post('singkatan')),
                'nama_divisi'          => strtoupper($request->post('nama_divisi')),
            ];
            // insert
            UnitKerjaDivisi::create($allowPost);

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

            UnitKerjaDivisi::findOrFail($id)->delete();
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
            $listIdDivisi = json_decode($request->post('id_divisi'), true);

            if (!is_array($listIdDivisi) || count($listIdDivisi) <= 0)
                throw new \Exception('Divisi tidak ditemukan');

            UnitKerjaDivisi::whereIn('id', $listIdDivisi)->delete();
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

            $old = UnitKerjaDivisi::findOrFail($id);
            $kodeDivisi = !empty($request->post('kode_divisi')) ? $request->post('kode_divisi') : $old->kode_divisi;
            $nama = !empty($request->post('nama_divisi')) ? $request->post('nama_divisi') : $old->nama_divisi;
            $singkatan = !empty($request->post('singkatan')) ? $request->post('singkatan') : $old->singkatan;

            $old->update([
                'id_unit_kerja_kepala'  => $request->post('id_unit_kerja_kepala') ?? $old->id_unit_kerja_kepala,
                'kode_divisi'           => strtoupper($kodeDivisi),
                'nama_divisi'           => strtoupper($nama),
                'singkatan'            => strtoupper($singkatan),
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
        'required'      => ':attribute harus diisi',
        'nama_divisi.max'      => 'kolom nama maksimal 100 karakter',
        'id_unit_kerja_kepala.max'  => 'kepala unit kerja melebihi 10 karatker'
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'id_unit_kerja_kepala'  => 'required|max:10',
            'nama_divisi'           => 'required|max:100',
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
