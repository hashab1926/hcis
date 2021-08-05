<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Pengajuan extends Model
{
    protected $fillable = [
        'nama_jenis',
        'nomor',
        'id_user',
        'data_template',
        'data_template_lampiran',
        'id_unit_kerja_divisi',
        'waktu_diacc',
        'status',
        'id_penandatangan',
        'status_edit',
        'waktu_lampiran'
    ];
    protected $table = 'pengajuan';

    // default field
    private static $column = [
        'pengajuan.id',
        'pengajuan.id_user',
        'pengajuan.nama_jenis',
        'pengajuan.nomor',
        'pengajuan.data_template',
        'pengajuan.data_template_lampiran',
        'pengajuan.created_at',
        'pengajuan.id_unit_kerja_divisi',
        'pengajuan.status',
        'pengajuan.waktu_diacc',
        'pengajuan.id_penandatangan',
        'pengajuan.status_edit',


    ];

    protected static $allow_limit = [10, 25, 50, 100];

    protected static $limit = 10;

    protected static $page = 1;

    protected static $total_row;

    // public $timestamps = false;

    public static function getPengajuan($request)
    {

        try {

            $get = DB::table('pengajuan')
                ->leftJoin('karyawan', 'karyawan.id_user', '=', 'pengajuan.id_user');

            // add select dari join
            $addSelect = [
                'karyawan.id AS id_pengaju',
                'karyawan.nip AS nip_pengaju',
                'karyawan.nama_karyawan AS nama_pengaju',
                'karyawan.email AS email_pengaju',

            ];

            self::$column = array_merge($addSelect, self::$column);
            // request param di kirim ke 'self'
            self::$request = $request;
            $get = self::getParam($get);

            // field yang ditampilkan
            $get = $get->get(self::$column);

            $response = [
                'status_code'    => 200,
                'message'        => 'ok',
                'limit'          => self::$limit,
                'total_row'      => self::$total_row,
                'page'           => self::$page,
                'data'           => $get->toArray(),
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } catch (QueryException $error) {
            $response = [
                'status_code' => 400,
                'message'     => 'Internal Server Error'
            ];
        } finally {
            return $response;
        }
    }

    public static function karyawanExists($request)
    {
        try {
            $get = DB::table('karyawan')
                ->join('pengajuan', 'pengajuan.id_user', '=', 'karyawan.id_user')
                ->groupBy('pengajuan.id_user', 'karyawan.id', 'karyawan.nama_karyawan', 'karyawan.email', 'karyawan.nip');

            // add select dari join
            self::$column = [
                'karyawan.id',
                'karyawan.nip',
                'karyawan.nama_karyawan',
                'karyawan.email',
                DB::raw("COUNT(pengajuan.id_user) AS total_pengajuan")
            ];

            // request param di kirim ke 'self'
            self::$request = $request;
            $get = self::getParam($get);

            // field yang ditampilkan
            $get = $get->get(self::$column);

            $response = [
                'status_code'    => 200,
                'message'        => 'ok',
                'limit'          => self::$limit,
                'total_row'      => self::$total_row,
                'page'           => self::$page,
                'data'           => $get->toArray(),
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage()
            ];
        } catch (QueryException $error) {
            $response = [
                'status_code' => 400,
                'message'     => 'Internal Server Error'
            ];
        } finally {
            return $response;
        }
    }

    public static function getAutoNumberGeneral($namaJenis)
    {
        $text = '';
        $nomor = Pengajuan::where('nama_jenis', $namaJenis)->count() + 1;
        if ($nomor <= 9) :
            $text = "0000000000{$nomor}/" . date('Y');
        elseif ($nomor <= 99) :
            $text = "000000000{$nomor}/" . date('Y');
        elseif ($nomor <= 999) :
            $text = "00000000{$nomor}/" . date('Y');
        elseif ($nomor <= 9999) :
            $text = "00000000{$nomor}/" . date('Y');
        elseif ($nomor <= 99999) :
            $text = "0000000{$nomor}/" . date('Y');
        elseif ($nomor <= 999999) :
            $text = "000000{$nomor}/" . date('Y');
        elseif ($nomor <= 9999999) :
            $text = "00000{$nomor}/" . date('Y');
        elseif ($nomor <= 99999999) :
            $text = "0000{$nomor}/" . date('Y');
        elseif ($nomor <= 999999999) :
            $text = "000{$nomor}/" . date('Y');
        elseif ($nomor <= 9999999999) :
            $text = "00{$nomor}/" . date('Y');
        elseif ($nomor <= 99999999999) :
            $text = "0{$nomor}/" . date('Y');
        elseif ($nomor <= 999999999999) :
            $text = "{$nomor}/" . date('Y');
        endif;

        return $text;
    }

    public static function getAutoNumberFaskom($namaJenis, $user)
    {
        $nomordivisi = $user->kode_divisi;
        $nomor = Pengajuan::where('nama_jenis', $namaJenis)->count() + 1;
        $tahun = date('Y');

        $nomorPengajuan  = "{$nomor}/{$nomordivisi}/{$tahun}";
        return $nomorPengajuan;
    }

    protected static $request;


    public static function getParam($query)
    {
        $request = self::$request;
        if (isset($request['id'])) {
            $explodeId = explode(',', $request['id']);

            // kalo param 'id' nya muliple
            if (is_array($explodeId) && count($explodeId) > 0) {
                $query = $query->whereIn('pengajuan.id', $explodeId);
            }
            // kalo param 'id' nya cuma 1
            else {

                $query = $query->where('pengajuan.id', $request['id']);
            }
        }
        if (isset($request['id_user'])) {
            $query = $query->where('pengajuan.id_user', $request['id_user']);
        }
        if (isset($request['id_penandatangan'])) {
            $query = $query->where('pengajuan.id_penandatangan', $request['id_penandatangan']);
        }
        if (isset($request['status'])) {
            $query = $query->where('pengajuan.status', $request['status']);
        }
        if (isset($request['id_unit_kerja_divisi'])) {
            $query = $query->where('pengajuan.id_unit_kerja_divisi', $request['id_unit_kerja_divisi']);
        }
        if (isset($request['reimburse_tahunbulan']) && $request['reimburse_tahunbulan'] == 'yes') {

            self::$column = array_merge([DB::raw("JSON_EXTRACT(pengajuan.data_template,'$.tahun_bulan') AS tahun_bulan")], self::$column);
        }

        if (isset($request['created_at'])) {
            $query = $query->where(DB::raw("DATE_FORMAT(pengajuan.created_at,'%Y-%m-%d')"), $request['created_at']);
        }


        if (isset($request['created_at_bulan'])) {
            $query = $query->where(DB::raw("DATE_FORMAT(pengajuan.created_at,'%Y-%m')"), $request['created_at_bulan']);
        }
        if (isset($request['created_at_tahun'])) {
            $query = $query->where(DB::raw("DATE_FORMAT(pengajuan.created_at,'%Y')"), $request['created_at_tahun']);
        }

        if (isset($request['date_range'])) {
            $explodeTgl = explode('|', $request['date_range']);
            $awal =  $explodeTgl[0];
            $akhir = $explodeTgl[1];

            $query = $query->where(DB::raw("JSON_EXTRACT(pengajuan.data_template,'$.tahun_bulan')"), '>=', $awal)
                ->where(DB::raw("JSON_EXTRACT(pengajuan.data_template,'$.tahun_bulan')"), '<=', $akhir);
        }

        if (isset($request['jenis_pengajuan'])) {
            if ($request['jenis_pengajuan'] == 'reimburse_faskom') {

                $query = $query->where('pengajuan.nama_jenis', 'RE_FASKOM');
            } elseif ($request['jenis_pengajuan'] == 'perjalanan_dinas') {

                $query = $query->where(function ($queryOr) {
                    $queryOr->orWhere('pengajuan.nama_jenis', 'PD_LKOTA')
                        ->orWhere('pengajuan.nama_jenis', 'PD_DKOTA')
                        ->orWhere('pengajuan.nama_jenis', 'PD_LNGRI');
                });
                // exit(1);
            } elseif ($request['jenis_pengajuan'] == 'perdin_luar_kota') {
                $query = $query->where('pengajuan.nama_jenis', 'PD_LKOTA');
            } elseif ($request['jenis_pengajuan'] == 'perdin_dalam_kota') {
                $query = $query->where('pengajuan.nama_jenis', 'PD_DKOTA');
            } elseif ($request['jenis_pengajuan'] == 'perdin_luar_negri') {
                $query = $query->where('pengajuan.nama_jenis', 'PD_LNGRI');
            } elseif ($request['jenis_pengajuan'] == 'cuti') {
                $query = $query->where('pengajuan.nama_jenis', 'CUTI');
            } elseif ($request['jenis_pengajuan'] == 'lembur') {
                $query = $query->where('pengajuan.nama_jenis', 'LEMBUR');
            }
        }

        if (isset($request['status'])) {
            if ($request['status'] == 'selesai')
                $query = $query->where('pengajuan.status', 'SELESAI');
            elseif ($request['status'] == 'proses')
                $query = $query->where('pengajuan.status', 'PROSES');
            elseif ($request['status'] == 'acc')
                $query = $query->where('pengajuan.status', 'ACC');
        }

        // param 'order_by'
        $query = self::paramOrderBy($query);

        // set 'total_row'
        self::$total_row = $query->count();

        // pagination
        $query = self::pagination($query);
        return $query;
    }

    private static function paramOrderBy($query)
    {
        $request = self::$request;

        // kalo param 'order_by' ada
        if (isset($request['order_by'])) {

            // kalo berdasarkan nama nomor A-Z
            if ($request['order_by'] == 'nomor_asc') {
                $query = $query->orderBy('pengajuan.nomor', 'ASC');
            }
            // kalo berdasarkan nama nomor Z-A
            elseif ($request['order_by'] == 'nomor_desc') {
                $query = $query->orderBy('pengajuan.nomor', 'DESC');
            } else {
                // settingan default order_by
                $query = $query->orderBy('pengajuan.id', 'DESC');
            }
        }

        return $query;
    }

    private static function pagination($query)
    {
        $request = self::$request;


        // cek ada ga limit nya 
        if (isset($request['limit']))
            self::$limit =  (int) @$request['limit'];

        // cek ada ga page
        if (isset($request['page']))
            self::$page =  (int) @$request['page'];

        // cek limit yang dimasukan, ada di allow_limit ga
        $limit = in_array(self::$limit, self::$allow_limit) ? self::$limit : 10;
        $offset = (self::$page - 1) * $limit;
        $query = $query->limit($limit)->offset($offset);

        return $query;
    }
}
