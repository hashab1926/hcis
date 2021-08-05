<?php

namespace App\Controllers\Rekap;

use App\Controllers\BaseController;
use App\Libraries\Library;
use App\Libraries\Pdf as Pdf;
use App\Libraries\RequestApi\FBCJ;

class FBCJController extends BaseController
{

    use ParamDatatable;
    use AjaxData;

    public function __construct()
    {
        $this->request = service('request');
        $this->fbcj = new Fbcj();
    }


    public function index()
    {
        return view('Rekap/Data');
    }
    public function buat()
    {
        // printr($_SESSION);
        return view('Rekap/BuatFBCJ');
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();

            // printr($_SESSION);

            // param datatable
            $param = $this->paramDatatable($input);


            $get = $this->fbcj->getFBCJ($param);

            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => $get->total_row,
                'recordsFiltered' => $get->total_row,
                'data'           => $get->data
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => 0,
                'recordsFiltered' => 0,
                'data'           => [],
                'message'        => $error->getMessage()
            ];
        } finally {
            echo json_encode($response);
        }
    }

    public function detail($id)
    {
        try {
            // printr($_SESSION);
            $get = $this->fbcj->getFbcj(['id' => $id]);
            if ($get->total_row <= 0)
                throw new \Exception("Detail FBCJ tidak ditemukan");
            $getDetail = $this->fbcj->getFbcjDetail([], $id);

            // printr($getDetail);
            if ($getDetail->total_row <= 0)
                throw new \Exception("Detail FBCJ tidak ditemukan");

            $getSubDetail = $this->fbcj->getFbcjSubDetail([], $id);

            $emptySubDetail = false;

            if ($getSubDetail->total_row <= 0)
                $emptySubDetail = true;

            // bukti 
            $getBukti = $this->fbcj->getBukti([], $id);
            $source = $get->data[0];
            $sourceDetail = $getDetail->data;
            return view("Rekap/DetailFbcj", [
                'fbcj'      => $source,
                'detail'    => $sourceDetail,
                'empty_sub_detail'  => $emptySubDetail,
                'fbcj_bukti'        => $getBukti->data
            ]);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage();
        }
    }

    public function subDetail($id)
    {
        try {
            $get = $this->fbcj->getFbcj(['id' => $id]);
            if ($get->total_row <= 0)
                throw new \Exception("= Detail FBCJ tidak ditemukan");

            $getDetail = $this->fbcj->getFbcjDetail([], $id);
            // printr($getDetail);
            if ($getDetail->total_row <= 0)
                throw new \Exception(" Detail FBCJ tidak ditemukan");


            $getSubDetail = $this->fbcj->getFbcjSubDetail([], $id);
            // printr($getSubDetail);

            $emptySubDetail = false;

            if ($getSubDetail->total_row <= 0)
                $emptySubDetail = true;

            $source = $get->data[0];
            $sourceDetail = $getDetail->data;
            $sourceSubDetail = $getSubDetail->data;
            $data =  [
                'fbcj'              => $source,
                'detail'            => $sourceDetail,
                'sub_detail'        => $sourceSubDetail,
                'empty_sub_detail'  => $emptySubDetail,
                'id_fbcj'           => $id
            ];
            // printr($data);
            return view("Rekap/SubDetailFbcj", $data);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage();
        }
    }

    public function store()
    {
        try {
            $input = $this->request->getPost();
            $files = $_FILES['bukti_file'];
            $data = [
                'tanggal'               => $input['tanggal'],
                'id_unit_kerja_divisi'  => $input['id_unit_kerja_divisi'],
                'kas_jurnal'            => $input['kas_jurnal'],
                'id_cost_center'        => $input['id_cost_center'],
                'id_penandatangan'      => $input['penandatangan'],
                'rincian'               => json_encode($input['rincian'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT),
            ];

            if (count($files['name']) > 0) :
                $tampungFiles = [];
                for ($x = 0; $x < count($files['name']); $x++) {
                    if (!empty($files['name'][$x]) && $files['error'][$x] == 0)
                        $tampungFiles["bukti_file[{$x}]"] =   $this->library->addFile($files['tmp_name'][$x], $files['type'][$x], $files['name'][$x]);
                }
                $data = array_merge($data, $tampungFiles);
            endif;

            // printr($data);
            $request = $this->fbcj->tambah($data);
            $response = [
                'status_code' => 201,
                'message'     => $request->message,
                'action'      => base_url('rekap/fbcj/buat')
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    public function subStore()
    {
        try {
            $input = $this->request->getPost();

            $dataInput = json_decode($input['data'], true);
            $data = [
                'data_sub'         => $input['data'],
            ];
            // printr($data);
            $request = $this->fbcj->tambahSubStore($data, $input['id_fbcj']);
            $response = [
                'status_code' => 201,
                'message'     => $request->message,
                'action'      => base_url('rekap/fbcj/sub_detail/' . $input['id_fbcj'])
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    public function preview($id = null)
    {
        try {
            $get = $this->fbcj->getFbcj([
                'id'            => $id,
                'penandatangan' => 'yes'
            ]);
            // printr($get);
            if ($get->total_row <= 0)
                throw new \Exception("Detail FBCJ tidak ditemukan");

            $getDetail = $this->fbcj->getFbcjDetail([], $id);
            // printr($getDetail);
            if ($getDetail->total_row <= 0)
                throw new \Exception(" Detail FBCJ tidak ditemukan");

            $source = $get->data[0];
            $sourceDetail = $getDetail->data;
            $data =  [
                'fbcj'              => $source,
                'detail'            => $sourceDetail,
                'id_fbcj'           => $id
            ];

            // printr($data);
            $preview = view('Pengajuan/Rekap/PreviewFBCJ', $data);
            // return $preview;
            // exit(1);
            $pdf = new Pdf();
            $pdf->htmlToPdf([
                'paper'  => 'A4',
                'layout' => 'portait',
                'title'  => 'Berkas',
                'author' => 'PT.INTI',
                'html'   => $preview,
            ]);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage();
        }
    }


    public function previewSubDetail($id = null)
    {
        try {
            $get = $this->fbcj->getFbcj([
                'id' => $id,
                'penandatangan' => 'yes'
            ]);

            if ($get->total_row <= 0)
                throw new \Exception("= Detail FBCJ tidak ditemukan");

            $getDetail = $this->fbcj->getFbcjDetail([], $id);
            // printr($getDetail);
            if ($getDetail->total_row <= 0)
                throw new \Exception(" Detail FBCJ tidak ditemukan");


            $getSubDetail = $this->fbcj->getFbcjSubDetail([], $id);
            // printr($getSubDetail);

            $emptySubDetail = false;

            if ($getSubDetail->total_row <= 0)
                $emptySubDetail = true;

            $source = $get->data[0];
            $sourceDetail = $getDetail->data;
            $sourceSubDetail = $getSubDetail->data;
            $data =  [
                'fbcj'              => $source,
                'detail'            => $sourceDetail,
                'sub_detail'        => $sourceSubDetail,
                'empty_sub_detail'  => $emptySubDetail,
                'id_fbcj'           => $id
            ];

            // printr($data);
            $preview = view('Pengajuan/Rekap/PreviewSubDetailFBCJ', $data);
            // return $preview;
            // exit(1);
            $pdf = new Pdf();
            $pdf->htmlToPdf([
                'paper'  => 'A4',
                'layout' => 'landscape',
                'title'  => 'Berkas',
                'author' => 'PT.INTI',
                'html'   => $preview,
            ]);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage();
        }
    }


    public function previewBukti($idFbcj, $idBukti)
    {
        try {
            $fbcj = $this->fbcj->getBukti(['id' => $idBukti], $idFbcj);
            if ($fbcj->total_row <= 0)
                throw new \Exception('FBCJ tidak ditemukan');

            // shorthand
            $source = $fbcj->data[0];
            $finfo = new \finfo(FILEINFO_MIME);
            $fileInfo = $finfo->buffer(base64_decode($source->bukti_file));
            $mimeType = explode('; ', $fileInfo)[0] ?? 'Tidak Diketahui';
            $ekstensi = $this->library->mimeToExt($mimeType);


            header("Content-type: {$mimeType}");
            $content = base64_decode($source->bukti_file);
            echo $content;
            exit(1);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage() . $error->getFile() . ' - ' . $error->getLine();
        }
    }
}




trait ParamDatatable
{
    private function paramDatatable($input)
    {
        $param = [
            'page'      => @$input['page'] ?? 1,
            'order_by'  => @$input['order_by'] ?? 'desc',
            'jenis_pengajuan'   => 'perjalanan_dinas'
        ];

        $param = array_merge($param, $this->paramOrderBy($input));
        return $param;
    }

    private function paramOrderBy($input)
    {
        $param = [];
        $indexOrder = $input['order'][0]['column'];
        $type = $input['order'][0]['dir'];

        $namaKolom = $input['columns'][$indexOrder]['data'];
        // nama_karyawan_asc / nama_karyawan_desc
        $orderBy = $namaKolom . "_" . $type;
        $param['order_by'] = $orderBy;
        return $param;
    }
}



trait AjaxData
{
    public function ajaxDataFbcj($idFbcj)
    {
        try {

            // set default param
            $param = [];

            // get method
            $input = $this->request->getGet();

            // param 'page' kalo ada
            if (!empty($input['page']))
                $param['page'] = $input['page'];

            // param 'q' kalo ada
            if (!empty($input['search']))
                $param['q'] = $input['search'];

            // get karyawan
            $get = $this->fbcj->getFbcjDetail($param, $idFbcj);
            // printr($get);
            $data = $get->data;
            $response = [];

            foreach ($data as $list) :
                $response['results'][] = [
                    'id'    => $list->id,
                    'text'  => $list->doc_no . ' - ' . $list->kode_bussiness_trans . ' ' . $list->nama_bussiness_trans
                ];
            endforeach;

            $response['pagination']['more'] = true;
            $response['count_filtered'] = $get->total_row;
            echo json_encode($response);
        } catch (\Exception | \Throwable $error) {
            echo json_encode(['error' => $error->getMessage()]);
        }
    }
}
