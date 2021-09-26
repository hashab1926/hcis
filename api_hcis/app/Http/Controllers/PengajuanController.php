<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\Pengajuan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Helpers\JwtHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\BlobHelper;

class PengajuanController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['q', 'id', 'created_at', 'tgl_cuti', 'tgl_berangkat_bulan', 'created_at_bulan', 'date_range_reimburse', 'created_at_tahun', 'status', 'limit', 'date_range', 'reimburse_tahunbulan', 'page', 'order_by', 'id_user', 'id_penandatangan', 'status', 'id_unit_kerja_divisi', 'jenis_pengajuan']);

        $get = Pengajuan::getPengajuan($allowGet);
        return response()->json($get);
    }

    public function pengajuanKaryawanExists(Request $request)
    {
        $allowGet = $request->only(['q', 'id', 'status', 'limit', 'date_range', 'reimburse_tahunbulan', 'page', 'order_by', 'id_user', 'id_penandatangan', 'status', 'id_unit_kerja_divisi', 'jenis_pengajuan']);

        $get = Pengajuan::karyawanExists($request);

        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);
            $getUser = JwtHelper::getUserToken(JwtHelper::getDataToken($request)['token']);
            $user = $getUser['data'][0];
            $dataTemplate = $request->post('data_template');
            $dataTemplateDecode = json_decode($dataTemplate, true);
            // cek penandatangan
            if (!isset($dataTemplateDecode['nama_penandatangan']))
                throw new \Exception("penandatangan belum diisi, silahkan isi penandatangan");

            $allowPost = [
                'data_template' => $dataTemplate,
                'nama_jenis'    => $request->post('nama_jenis'),
                'id_user'       => $user->id,
                'id_unit_kerja_divisi'   => $user->id_unit_kerja_divisi,
                'id_penandatangan'       => $dataTemplateDecode['nama_penandatangan'],
                'nomor'                  => Pengajuan::getAutoNumberGeneral($request->post('nama_jenis'))
            ];

            switch ($request->post('nama_jenis')) {

                case 'RE_FASKOM':
                    $allowPost['nomor'] = Pengajuan::getAutoNumberFaskom($request->post('nama_jenis'), $user);
                    break;
            }

            // insert
            Pengajuan::create($allowPost);

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


    public function update($id, Request $request)
    {
        try {
            // set tules
            // $this->rules($request);

            $old = Pengajuan::findOrFail($id);
            $status = !empty($request->post('status')) ? $request->post('status') : $old->status;
            $waktuAcc = !empty($request->post('waktu_diacc')) ? $request->post('waktu_diacc') : $old->waktu_diacc;
            $statusEdit = !empty($request->post('status_edit')) ? $request->post('status_edit') : $old->status_edit;

            $old->update([
                'status'        => $status,
                'wakti_diacc'   => $waktuAcc,
                'status_edit'   => $statusEdit
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

    public function updateLampiran($id, Request $request)
    {
        try {
            // set tules
            // $this->rules($request);
            $old = Pengajuan::findOrFail($id);
            $decodeTemplate = !empty($request->post('data_template')) ? $request->post('data_template') : $old->data_template;
            if (!empty($request->post('data_template'))) {
                $decodeTemplate = json_decode($request->post('data_template'), true);
                $oldDecodeTemplate = json_decode($old->data_template, true);
                $decodeTemplate = array_merge($oldDecodeTemplate, $decodeTemplate);
            }
            $dataTemplateLampiran = !empty($request->post('data_template_lampiran')) ? $request->post('data_template_lampiran') : $old->data_template_lampiran;
            // ubah template
            $old->update([
                'data_template'           => $decodeTemplate,
                'data_template_lampiran'  => $dataTemplateLampiran,
                'waktu_lampiran'          => date('Y-m-d H:i:s'),
                'status'                  => 'SELESAI'
            ]);

            // tambah lampiran pada table 'lampiran_pengajuan'
            if (!empty($_FILES['bukti_file'])) :
                $cekLampiran = DB::table('lampiran_pengajuan')->where('id_pengajuan', '=', $old->id)->count();

                // kalo lapirannya udah pernah di insert sebelumnya
                if ($cekLampiran > 0) {
                    // delete lampiran by id_pengajuan
                    DB::table('lampiran_pengajuan')->where('id_pengajuan', '=', $old->id)->delete();
                }

                $lampiran = $request->file('bukti_file');
                $length = count($lampiran);
                if ($length > 0) {
                    $dataTampung = [];
                    for ($x = 0; $x < $length; $x++) {
                        $dataTampung[] = [
                            'id_pengajuan'  => $old->id,
                            'bukti_file'    => BlobHelper::fileToBlob($lampiran[$x])
                        ];
                    }
                    DB::table('lampiran_pengajuan')->insert($dataTampung);
                }

            endif;
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
        'required'              => ':attribute harus diisi',
        'data_template.max'     => 'form pengajuan harus diisi'
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'data_template'  => 'required',
            'nama_jenis'     => 'required'
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
