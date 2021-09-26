<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\Jabatan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class JabatanController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'id_unit_kerja_bagian', 'limit', 'page', 'order_by', 'q']);

        $get = Jabatan::getJabatan($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'nama_jabatan'          => strtoupper($request->post('nama_jabatan')),
                'id_unit_kerja_bagian' => $request->post('id_unit_kerja_bagian'),

            ];
            // insert
            Jabatan::create($allowPost);

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

            Jabatan::findOrFail($id)->delete();
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

    public function multipleDelete(Request $request)
    {
        try {
            $listIdJabatan = json_decode($request->post('id_jabatan'), true);

            if (!is_array($listIdJabatan) || count($listIdJabatan) <= 0)
                throw new \Exception('Karyawan tidak ditemukan');

            Jabatan::whereIn('id', $listIdJabatan)->delete();
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

            $old = Jabatan::findOrFail($id);
            $nama = !empty($request->post('nama_jabatan')) ? $request->post('nama_jabatan') : $old->nama_jabatan;
            $idBagian = !empty($request->post('id_unit_kerja_bagian')) ? $request->post('id_unit_kerja_bagian') : $old->id_unit_kerja_bagian;

            $old->update([
                'nama_jabatan'          => strtoupper($nama),
                'id_unit_kerja_bagian'  => $idBagian
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
        } catch (\Exception | \Throwable $Error) {
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
        'nama_jabatan.required' => 'jabatan harus diisi',
        'nama_jabatan.max'      => 'kolom jabatan maksimal 100 karakter'
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'nama_jabatan'  => 'required|max:100',
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
