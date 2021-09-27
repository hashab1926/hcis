<?php

namespace App\Controllers;

use App\Libraries\RequestApi\Pengajuan;
use App\Libraries\Library;
use App\Libraries\RequestApi\Karyawan;
use App\Libraries\Pdf as Pdf;

class PengajuanController extends BaseController
{
    use ParamDatatable;

    public function __construct()
    {
        $this->request = service('request');
        $this->pengajuan = new Pengajuan();
    }


    public function index()
    {
        return view('Pengajuan/SemuaPengajuan');
    }


    public function indexSaya()
    {
        return view('Pengajuan/PengajuanSaya');
    }


    public function getDatatable()
    {
        try {
            $input = $this->request->getGet();


            // param datatable
            $param = $this->paramDatatable($input);

            // get karyawan
            $pengajuan = $this->pengajuan->getPengajuan($param);
            // printr($pengajuan->data);
            $library = new Library();
            $x = 0;
            $tempPengajuan = $pengajuan->data;
            foreach ($tempPengajuan as $list) :
                $pengajuan->data[$x++]->created_at = $library->timeToText($list->created_at);
            endforeach;
            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => $pengajuan->total_row,
                'recordsFiltered' => $pengajuan->total_row,
                'data'           => $pengajuan->data
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

    public function getDatatableSaya()
    {
        try {
            $input = $this->request->getGet();

            // param datatable
            $param = $this->paramDatatableSaya($input);

            // get karyawan
            $pengajuan = $this->pengajuan->getPengajuan($param);
            // printr($pengajuan);
            $library = new Library();
            $x = 0;
            $tempPengajuan = $pengajuan->data;
            foreach ($tempPengajuan as $list) :
                $pengajuan->data[$x++]->created_at = $library->timeToText($list->created_at);
            endforeach;
            $response = [
                'draw'           => $input['draw'] ?? 1,
                'recordsTotal'   => $pengajuan->total_row,
                'recordsFiltered' => $pengajuan->total_row,
                'data'           => $pengajuan->data
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

    public function ubahPengajuan($id)
    {
        try {
            $pengajuan = $this->pengajuan->getPengajuan(['id' => $id]);
            if ($pengajuan->total_row <= 0)
                throw new \Exception('Pengajuan tidak ditemukan');

            // shorthand
            $source = $pengajuan->data[0];
            // printr($source);
            // id_pengaju
            $idPengaju = $source->id_pengaju;

            $this->karyawan = new Karyawan();
            $karyawan = $this->karyawan->getKaryawan(['id' => $idPengaju]);

            // cek pengaju
            if ($karyawan->total_row <= 0)
                throw new \Exception('Nama Pengaju tidak ditemukan');

            // penandatangan
            $penandatangan = json_decode($source->data_template, true);
            if (!is_array($penandatangan))
                throw new \Exception('template mungkin rusak, silahkan coba beberapa saat lagi');

            $idPenandatangan = $penandatangan['nama_penandatangan'];
            $penandatangan = $this->karyawan->getKaryawan(['id' => $idPenandatangan]);

            if ($penandatangan->total_row <= 0)
                throw new \Exception('penandatangan tidak ditemukan');


            $userLogin = $this->credential->cekCredential();

            $data = [
                'status_code'  => 200,
                'pengajuan'    => $source,
                'pengaju'      => $karyawan->data[0],
                'penandatangan' => $penandatangan->data[0],
                '_nama_jenis'   => $source->nama_jenis,
                'nama_jenis'    => $this->namaJenisToView(($source->nama_jenis)),
                'user'          => $userLogin,
                'template'      => json_decode($source->data_template)
            ];
        } catch (\Exception | \Throwable $error) {
            $data = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {
            // printr($data);
            return view('Pengajuan/Lampiran/PerdinLuarKota', $data);
        }
    }


    public function tambah()
    {
        try {

            $view = 'Pengajuan/Tambah';

            $input = $this->request->getGet();
            $userLogin = $this->credential->cekCredential();
            // printr($userLogin);
            $data = [
                'status_code'       => 2020,
                'message'           => 'ok',
                // 'full_page'         => true,
                'user'              => $userLogin,
                'buat_pengajuan'    => true
            ];
            $data['nama_pengajuan'] = '';
            if (isset($input['jenis_pengajuan'])) {
                switch ($input['jenis_pengajuan']) {
                    case 'perdin_luarkota':
                        $view = 'Pengajuan/Jenis/PerdinLuarKota';
                        $data['nama_pengajuan'] = 'Perjalanan Dinas Luar Kota';
                        break;
                    case 'perdin_dalamkota':
                        $view = 'Pengajuan/Jenis/PerdinDalamKota';
                        $data['nama_pengajuan'] = 'Perjalanan Dinas Dalam Kota';
                        break;
                    case 'perdin_luarnegri':
                        $view = 'Pengajuan/Jenis/PerdinLuarNegri';
                        $data['nama_pengajuan'] = 'Perjalanan Dinas Luar Negri';

                        break;

                    case 'reimburse_faskom':
                        $dataPengajuan = $this->pengajuan->getPengajuan(['jenis_pengajuan' => 'reimburse_faskom']);
                        $nomor = $dataPengajuan->total_row + 1;
                        $nomorDivisi = $userLogin->kode_divisi;
                        $tahun = date('Y');
                        $data['nomor_pengajuan'] = "{$nomor}/{$nomorDivisi}/$tahun";
                        $view = 'Pengajuan/Jenis/ReimburseFaskom';
                        $data['nama_pengajuan'] = 'Reimburse Fasilitas Komunikasi';

                        break;
                    case 'cuti_karyawan':
                        $view = 'Pengajuan/Jenis/CutiKaryawan';
                        $data['nama_pengajuan'] = 'Cuti Karyawan';
                        break;
                    case 'lembur_karyawan':
                        $view = 'Pengajuan/Jenis/LemburKaryawan';
                        $data['nama_pengajuan'] = 'Lembur Karyawan';

                        break;
                }
            } else {
                $data['status_code'] = 100;
                $data['message'] = "Silahkan pilih jenis pengajuan";
            }
        } catch (\Exception | \Throwable $error) {
            $data = [
                'status_code'    => 400,
                'message'        => $error->getMessage()
            ];
        } finally {
            // printr($data);
            return view($view, $data);
        }
    }


    public function store()
    {
        try {
            $input = $this->request->getPost();
            // cek nama_jenis 
            if (!isset($input['nama_jenis']))
                throw new \Exception('Nama jenis surat tidak terdaftar');


            $data = [
                'nama_jenis'    =>  $this->namaJenis($input['nama_jenis']),
                'data_template' =>  json_encode($input['templating'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT)
            ];

            // printr($data);
            $this->pengajuan->tambah($data);

            $response = [
                'status_code'   => 201,
                'message'       => 'Pengajuan telah ditambahkan',
                'action'        => base_url('pengajuan/tambah')
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    public function storeAcc()
    {
        try {
            $input = $this->request->getPost();

            $id = $input['id'];

            // cek id
            $pengajuan = $this->pengajuan->getPengajuan(['id' => $id]);
            if ($pengajuan->total_row <= 0)
                throw new \Exception('Pengajuan tidak ditemukan');

            $source = $pengajuan->data[0];
            $userLogin = $this->credential->cekCredential();
            // cek apakah kepala divisi
            if ($userLogin->id_karyawan != $source->id_penandatangan)
                throw new \Exception('anda bukan penandatangan, silahkan coba beberapa saat lagi');

            if ($userLogin->status  == '1')
                throw new \Exception('anda tidak memiliki izin untuk menandatangan, silahkan hubungi administrator');


            $data = [
                'status'        => 'ACC',
                'waktu_diacc'   => date('Y-m-d H:i:s')
            ];

            // kalo jenis pengajuan reimburse
            if ($source->nama_jenis == 'RE_FASKOM')
                $data['status'] = 'SELESAI';

            $this->pengajuan->ubah($id, $data);

            $response = [
                'status_code'   => 200,
                'message'       => 'Pengajuan telah diacc',
                'action'        => base_url('pengajuan/detail/' . $id)
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    public function storeBatal()
    {
        try {
            $input = $this->request->getPost();

            $id = $input['id'];

            // cek id
            $pengajuan = $this->pengajuan->getPengajuan(['id' => $id]);
            if ($pengajuan->total_row <= 0)
                throw new \Exception('Pengajuan tidak ditemukan');

            $source = $pengajuan->data[0];
            $userLogin = $this->credential->cekCredential();
            // cek apakah kepala divisi
            if ($userLogin->id_karyawan != $source->id_penandatangan)
                throw new \Exception('anda bukan penandatangan, silahkan coba beberapa saat lagi');

            if ($userLogin->status  == '1')
                throw new \Exception('anda tidak memiliki izin untuk menandatangan, silahkan hubungi administrator');

            $data = [
                'status'        => 'TOLAK',
                'waktu_diacc'   => date('Y-m-d H:i:s')
            ];

            $this->pengajuan->ubah($id, $data);

            $response = [
                'status_code'   => 200,
                'message'       => 'Pengajuan telah di tolak',
                'action'        => base_url('pengajuan/detail/' . $id)
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    public function storeLampiran()
    {
        try {
            $input = $this->request->getPost();
            $files = $_FILES['bukti_file'];
            $dataTemplate = $input['templating'];
            $lamaPerdin = $dataTemplate['lama_perdin_realisasi'] ?? null;

            $data = [
                'waktu_realisasi'        => $lamaPerdin,
                'data_template'          => json_encode($input['templating'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT),
                'data_template_lampiran' => json_encode($input['templating_lampiran'], JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT),
            ];

            // tambahkan upload lampiran
            if (count($files['name']) > 0) :
                $tampungFiles = [];
                for ($x = 0; $x < count($files['name']); $x++) {
                    if (!empty($files['name'][$x]) && $files['error'][$x] == 0)
                        $tampungFiles["bukti_file[{$x}]"] =   $this->library->addFile($files['tmp_name'][$x], $files['type'][$x], $files['name'][$x]);
                }
                $data = array_merge($data, $tampungFiles);
            endif;

            // printr($data);


            // printr($data);
            $this->pengajuan->ubahLampiran($input['id'], $data);

            $response = [
                'status_code'   => 200,
                'message'       => 'Pengajuan telah ditambahkan',
                'action'        => base_url('pengajuan/detail/' . $input['id'])
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage() . $error->getFile() . $error->getLine()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    public function storeAccAjuan()
    {
        try {
            $input = $this->request->getPost();

            $id = $input['id'];

            // cek id
            $pengajuan = $this->pengajuan->getPengajuan(['id' => $id]);
            if ($pengajuan->total_row <= 0)
                throw new \Exception('Pengajuan tidak ditemukan');

            $source = $pengajuan->data[0];
            $userLogin = $this->credential->cekCredential();

            if ($userLogin->level != '3')
                throw new \Exception('anda bukan penandatangan, silahkan coba beberapa saat lagi');


            // cek apakah kepala divisi
            if ($userLogin->id_karyawan != $source->id_penandatangan)
                throw new \Exception('anda tidak memiliki izin untuk akses aksi ini, silahkan coba beberapa saat lagi');

            $data = ['status_edit' => 'Y'];
            $this->pengajuan->ubah($id, $data);

            $response = [
                'status_code'   => 200,
                'message'       => 'Ajuan telah diberi akses',
                'action'        => base_url('pengajuan/detail/' . $id)
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }

    public function storeAjuan()
    {
        try {
            $input = $this->request->getPost();

            $id = $input['id'];

            // cek id
            $pengajuan = $this->pengajuan->getPengajuan(['id' => $id]);
            if ($pengajuan->total_row <= 0)
                throw new \Exception('Pengajuan tidak ditemukan');

            $source = $pengajuan->data[0];
            $userLogin = $this->credential->cekCredential();

            if ($userLogin->level != '2')
                throw new \Exception('anda bukan admin divisi, silahkan coba beberapa saat lagi');

            // cek apakah admin divisi
            if ($userLogin->id_unit_kerja_divisi != $source->id_unit_kerja_divisi)
                throw new \Exception('anda bukan dari divisi ini, silahkan coba beberapa saat lagi');

            $data = ['status_edit' => 'PENDING'];
            $this->pengajuan->ubah($id, $data);

            $response = [
                'status_code'   => 200,
                'message'       => 'Pengajuan ini telah di ajukan',
                'action'        => base_url('pengajuan/detail/' . $id)
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code'   => 400,
                'message'       => $error->getMessage()
            ];
        } finally {
            $response['token'] = csrf_hash();
            echo json_encode($response);
        }
    }



    public function detail($id)
    {
        try {
            $pengajuan = $this->pengajuan->getPengajuan(['id' => $id]);
            if ($pengajuan->total_row <= 0)
                throw new \Exception('Pengajuan tidak ditemukan');

            // shorthand
            $source = $pengajuan->data[0];
            // printr($source);
            // id_pengaju
            $idPengaju = $source->id_pengaju;

            $this->karyawan = new Karyawan();
            $karyawan = $this->karyawan->getKaryawan(['id' => $idPengaju]);

            // cek pengaju
            if ($karyawan->total_row <= 0)
                throw new \Exception('Nama Pengaju tidak ditemukan');

            // penandatangan
            $penandatangan = json_decode($source->data_template, true);
            if (!is_array($penandatangan))
                throw new \Exception('template mungkin rusak, silahkan coba beberapa saat lagi');

            $idPenandatangan = $penandatangan['nama_penandatangan'];
            $penandatangan = $this->karyawan->getKaryawan(['id' => $idPenandatangan]);

            if ($penandatangan->total_row <= 0)
                throw new \Exception('penandatangan tidak ditemukan');


            $userLogin = $this->credential->cekCredential();

            $lampiranPengajuan = $this->pengajuan->getLampiran($id);

            $data = [
                'status_code'  => 200,
                'pengajuan'    => $source,
                'pengaju'      => $karyawan->data[0],
                'penandatangan' => $penandatangan->data[0],
                '_nama_jenis'   => $source->nama_jenis,
                'nama_jenis'    => $this->namaJenisToView(($source->nama_jenis)),
                'user'          => $userLogin,
            ];

            if ($source->nama_jenis == 'PD_LKOTA' || $source->nama_jenis == 'PD_DKOTA' ||  $source->nama_jenis == 'PD_LNGRI') {
                $data = array_merge($data, [
                    'lampiran'      => $lampiranPengajuan->data,
                    'view'          => 'Pengajuan/Detail/DetailPerdin'
                ]);
            } elseif ($source->nama_jenis == 'RE_FASKOM') {
                $data = array_merge($data, [
                    'view'          => 'Pengajuan/Detail/DetailReimburse'
                ]);
            } elseif ($source->nama_jenis == 'CUTI') {
                $data = array_merge($data, [
                    'view'          => 'Pengajuan/Detail/DetailCuti'
                ]);
            } elseif ($source->nama_jenis == 'LEMBUR') {
                $data = array_merge($data, [
                    'view'          => 'Pengajuan/Detail/DetailLembur'
                ]);
            }
        } catch (\Exception | \Throwable $error) {
            $data = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } finally {

            if (!isset($data['view']))
                $data['view'] = 'Pengajuan/Detail/ErrorMessage';
            // printr($data);
            return view($data['view'], $data);
        }
    }

    public function previewLampiranPengajuan($id)
    {
        try {
            $pengajuan = $this->pengajuan->getPengajuan(['id' => $id]);
            if ($pengajuan->total_row <= 0)
                throw new \Exception('Pengajuan tidak ditemukan');

            // shorthand
            $source = $pengajuan->data[0];
            // printr($source);
            // id_pengaju
            $idPengaju = $source->id_pengaju;

            $this->karyawan = new Karyawan();
            $karyawan = $this->karyawan->getKaryawan(['id' => $idPengaju]);

            // cek pengaju
            if ($karyawan->total_row <= 0)
                throw new \Exception('Nama Pengaju tidak ditemukan');

            // penandatangan
            $penandatangan = json_decode($source->data_template_lampiran, true);
            if (!is_array($penandatangan))
                throw new \Exception('template mungkin rusak, silahkan coba beberapa saat lagi');

            $idPenandatangan = $penandatangan['nama_penandatangan'];
            $penandatangan = $this->karyawan->getKaryawan(['id' => $idPenandatangan]);

            if ($penandatangan->total_row <= 0)
                throw new \Exception('penandatangan tidak ditemukan');

            $data = [
                'status_code'  => 200,
                'pengajuan'    => $source,
                'pengaju'      => $karyawan->data[0],
                'penandatangan' => $penandatangan->data[0],
                'nama_jenis'    => $this->namaJenisToView(($source->nama_jenis)),
                'lampiran'      => json_decode($source->data_template_lampiran)
            ];


            // printr($data);

            $preview = view('Pengajuan/Preview/LampiranPerdinLuarKota', $data);
            // echo $preview;
            // exit(1);

            $pdf = new Pdf();
            $pdf->htmlToPdf([
                'paper'  => 'A4',
                'title'  => $data['nama_jenis'],
                'author' => 'PT.INTI',
                'html'   => $preview
            ]);
            // $pdf->filename = str_replace(' ', '-', $data['nama_jenis']) . '.pdf';
            // $pdf->setPaper('A4', 'portait');
            // $pdf->loadView('Pengajuan/Preview', $data);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage() . $error->getFile() . ' - ' . $error->getLine();
        }
    }

    public function previewLampiran($id)
    {
        try {
            $lampiran = $this->pengajuan->getLampiran(null, ['id' => $id]);
            if ($lampiran->total_row <= 0)
                throw new \Exception('Lampiran tidak ditemukan');
            // shorthand
            $source = $lampiran->data[0];
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

    public function preview($id)
    {
        try {

            $pengajuan = $this->pengajuan->getPengajuan(['id' => $id]);
            if ($pengajuan->total_row <= 0)
                throw new \Exception('Pengajuan tidak ditemukan');

            // shorthand
            $source = $pengajuan->data[0];
            // printr($source);
            // id_pengaju
            $idPengaju = $source->id_pengaju;

            $this->karyawan = new Karyawan();
            $karyawan = $this->karyawan->getKaryawan(['id' => $idPengaju]);

            // cek pengaju
            if ($karyawan->total_row <= 0)
                throw new \Exception('Nama Pengaju tidak ditemukan');

            // penandatangan
            $penandatangan = json_decode($source->data_template, true);
            if (!is_array($penandatangan))
                throw new \Exception('template mungkin rusak, silahkan coba beberapa saat lagi');

            $idPenandatangan = $penandatangan['nama_penandatangan'];
            $penandatangan = $this->karyawan->getKaryawan(['id' => $idPenandatangan]);

            if ($penandatangan->total_row <= 0)
                throw new \Exception('penandatangan tidak ditemukan');

            $data = [
                'status_code'  => 200,
                'pengajuan'    => $source,
                'pengaju'      => $karyawan->data[0],
                'penandatangan' => $penandatangan->data[0],
                'nama_jenis'    => $this->namaJenisToView(($source->nama_jenis)),
                'template'      => json_decode($source->data_template),
            ];
            // printr($source);

            if ($source->nama_jenis == 'PD_LKOTA' || $source->nama_jenis == 'PD_DKOTA' || $source->nama_jenis == 'PD_LNGRI') {
                $preview = view('Pengajuan/Berkas/BerkasPerdinLuarKota', $data);
            } elseif ($source->nama_jenis == 'RE_FASKOM') {
                $preview = view('Pengajuan/Berkas/BerkasReimburse', $data);
            } elseif ($source->nama_jenis == 'CUTI') {
                $preview = view('Pengajuan/Berkas/BerkasCuti', $data);
            } elseif ($source->nama_jenis == 'LEMBUR') {
                $preview = view('Pengajuan/Berkas/BerkasLembur', $data);
            }
            // echo $preview;
            // exit(1);

            $pdf = new Pdf();
            $pdf->htmlToPdf([
                'paper'  => 'A4',
                'title'  => $data['nama_jenis'],
                'author' => 'PT.INTI',
                'html'   => $preview
            ]);
            // $pdf->filename = str_replace(' ', '-', $data['nama_jenis']) . '.pdf';
            // $pdf->setPaper('A4', 'portait');
            // $pdf->loadView('Pengajuan/Preview', $data);
        } catch (\Exception | \Throwable $error) {
            echo $error->getMessage() . $error->getFile() . ' - ' . $error->getLine();
        }
    }

    private function namaJenis($nama)
    {
        $text = '';
        switch ($nama) {
            case 'perdin_luarkota':
                $text = 'PD_LKOTA';
                break;
            case 'perdin_dalamkota':
                $text = 'PD_DKOTA';
                break;
            case 'perdin_luarnegri':
                $text = 'PD_LNGRI';
                break;
            case 'reimburse_faskom':
                $text = 'RE_FASKOM';
                break;
            case 'cuti_karyawan':
                $text = 'CUTI';
                break;
            case 'lembur_karyawan':
                $text = 'LEMBUR';

                break;
        }

        return $text;
    }

    private function namaJenisToView($nama)
    {
        $text = '';
        switch ($nama) {
            case 'PD_LKOTA':
                $text = 'Surat Perjalanan Dinas Luar Kota';
                break;
            case 'PD_DKOTA':
                $text = 'Surat Perjalanan Dinas Dalam Kota';
                break;
            case 'PD_LNGRI':
                $text = 'Surat Perjalanan Dinas Luar Negri';
                break;
            case 'RE_FASKOM':
                $text = 'Reimburse Fasilitas Komunikasi';
                break;
            case 'CUTI':
                $text = 'Pengajuan Cuti Karyawan';
                break;
            case 'LEMBUR':
                $text = 'Pengajuan Lembur Karyawan';
                break;
        }

        return $text;
    }
}


trait ParamDatatable
{
    private function paramDatatable($input)
    {
        $param = [
            'page'      => @$input['page'] ?? 1,
            'order_by'  => @$input['order_by'] ?? 'desc',
            'q'         => @$input['search']['value']
        ];

        $param = array_merge($param, $this->paramOrderBy($input));
        // printr($param);
        return $param;
    }

    private function paramDatatableSaya($input)
    {
        $user = $this->credential->cekCredential();
        // printr($user);
        $param = [
            'page'      => @$input['page'] ?? 1,
            'order_by'  => @$input['order_by'] ?? 'desc',
            'id_user'   => $user->id
        ];

        $param = array_merge($param, $this->paramOrderBy($input));
        // printr($param);
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
