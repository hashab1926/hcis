<?php

namespace App\Http\Controllers\Lainnya;

use Validator;

use App\Models\WbsElement;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Database\QueryException;

class WbsElementController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page']);

        $get = WbsElement::getWbsElement($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'kode_wbs_element' => $request->post('kode_wbs_element'),
                'nama_wbs_element' => strtoupper($request->post('nama_wbs_element')),
            ];
            // insert
            WbsElement::create($allowPost);

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

            WbsElement::findOrFail($id)->delete();
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

            $old = WbsElement::findOrFail($id);
            $kode = !empty($request->post('kode_wbs_element')) ? $request->post('kode_wbs_element') : $old->kode_wbs_element;
            $nama = !empty($request->post('nama_wbs_element')) ? $request->post('nama_wbs_element') : $old->nama_wbs_element;

            $old->update([
                'kode_wbs_element'    => $kode,
                'nama_wbs_element'    => strtoupper($nama)
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
            $listIdWbsElement = json_decode($request->post('id_wbs_element'), true);

            if (!is_array($listIdWbsElement) || count($listIdWbsElement) <= 0)
                throw new \Exception('Wbs Element tidak ditemukan');

            WbsElement::whereIn('id', $listIdWbsElement)->delete();
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
        'nama_wbs_element.max'      => 'kolom nama maksimal 100 karakter',
        'kode_wbs_element.max'      => 'kolom kode maksimal 50 karakter',
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'kode_wbs_element'  => 'required|max:50',
            'nama_wbs_element'  => 'required|max:100',
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
