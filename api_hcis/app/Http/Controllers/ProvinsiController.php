<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class ProvinsiController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page', 'order_by', 'q']);

        $get = Provinsi::getProvinsi($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'nama_provinsi' => strtoupper($request->post('nama_provinsi'))
            ];
            // insert
            Provinsi::create($allowPost);

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

            Provinsi::findOrFail($id)->delete();
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
            $listIdProvinsi = json_decode($request->post('id_provinsi'), true);

            if (!is_array($listIdProvinsi) || count($listIdProvinsi) <= 0)
                throw new \Exception('Karyawan tidak ditemukan');

            Provinsi::whereIn('id', $listIdProvinsi)->delete();
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

            $old = Provinsi::findOrFail($id);
            $nama = !empty($request->post('nama_provinsi')) ? $request->post('nama_provinsi') : $old->nama_provinsi;

            $old->update([
                'nama_provinsi'    => strtoupper($nama)
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
        'nama_provinsi.required' => 'pangkat harus diisi',
        'nama_provinsi.max'      => 'kolom pangkat maksimal 100 karakter'
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'nama_provinsi'  => 'required|max:100',
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
