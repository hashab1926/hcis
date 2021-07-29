<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\JenisPengajuan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Helpers\BlobHelper;
use Barryvdh\DomPDF\Facade as PDF;
use App\Helpers\Template\MainTemplateHelper as Template;

class JenisPengajuanController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page']);

        $get = JenisPengajuan::getJenisPengajuan($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'nama_jenis' => strtoupper($request->post('nama_jenis')),
                // 'nama' => strtoupper($request->post('nama')),
            ];

            $file = $request->file('template_file') ?? null;

            // cek 'template_file'
            if ($request->hasFile('template_file'))
                $allowPost['template_file'] = BlobHelper::fileToBlob($file);

            // insert
            JenisPengajuan::create($allowPost);

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

            JenisPengajuan::findOrFail($id)->delete();
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

            $old = JenisPengajuan::findOrFail($id);
            $nama = !empty($request->post('nama_jenis')) ? $request->post('nama_jenis') : $old->nama_jenis;

            $old->update([
                'nama_jenis'    => strtoupper($nama)
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

    public function getInputTemplate($id)
    {
        try {

            $jenis = JenisPengajuan::findOrFail($id);
            $templateFile = base64_decode($jenis->template_file);

            $template = new Template();
            $template->html = $templateFile;

            $run = $template->listKeywordInput();

            $response = [
                'status_code'  => 200,
                'data'         => $run
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            return response()->json($response);
        }
    }
    public function preview($id, Request $request)
    {
        try {

            $jenis = JenisPengajuan::findOrFail($id);
            $templateFile = base64_decode($jenis->template_file);

            $template = new Template();
            $template->html = $templateFile;

            $dataTemplate = null;
            if (isset($request['templating']))
                $dataTemplate = json_decode($request['templating'], true);

            // request dikirim ke template
            $template->request = $request;

            // jalankan template
            $run = $template->getDataInit()
                ->getDataLogin()
                ->getDataAuto()
                ->getDataInput($dataTemplate)
                ->removeKeyword()
                ->get();

            // encoding template
            $encodeTemplate = $template->encodeHtml($run);

            // response 
            $response = [
                'status_code'        => 200,
                'encode_template'    => $encodeTemplate
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage() . $error->getFile() . $error->getLine()
            ];
        } finally {
            echo json_encode($response);
        }
    }
}


trait Rules
{
    private $message = [
        'nama_jenis.required' => 'jenis pengajuan harus diisi',
        'nama_jenis.max'      => 'kolom jenis pengajuan maksimal 100 karakter'
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'nama_jenis'  => 'required|max:100',
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
