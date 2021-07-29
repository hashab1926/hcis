<?php

namespace App\Http\Controllers\Lainnya;

use Validator;

use App\Models\CostCenter;
use Illuminate\Http\Request;
use Laravel\Lumen\Routing\Controller;
use Illuminate\Database\QueryException;

class CostCenterController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page']);

        $get = CostCenter::getCostCenter($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'kode_cost_center' => $request->post('kode_cost_center'),
                'nama_cost_center' => strtoupper($request->post('nama_cost_center')),
            ];
            // insert
            CostCenter::create($allowPost);

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

            CostCenter::findOrFail($id)->delete();
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

            $old = CostCenter::findOrFail($id);
            $kode = !empty($request->post('kode_cost_center')) ? $request->post('kode_cost_center') : $old->kode_cost_center;
            $nama = !empty($request->post('nama_cost_center')) ? $request->post('nama_cost_center') : $old->nama_cost_center;
            $old->update([
                'kode_cost_center'    => $kode,
                'nama_cost_center'    => strtoupper($nama),
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
            $listIdCostCenter = json_decode($request->post('id_cost_center'), true);

            if (!is_array($listIdCostCenter) || count($listIdCostCenter) <= 0)
                throw new \Exception('cost center tidak ditemukan');

            CostCenter::whereIn('id', $listIdCostCenter)->delete();
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
        'nama_cost_center.max'      => 'kolom nama maksimal 100 karakter',
        'kode_cost_center.max'      => 'kolom kode maksimal 50 karakter',

    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'kode_cost_center'  => 'required|max:50',
            'nama_cost_center'  => 'required|max:100',
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
