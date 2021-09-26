<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Fbcj extends Model
{
    protected $fillable = [
        'nomor',
        'id_unit_kerja_divisi',
        'tanggal',
        'kas_jurnal',
        'id_cost_center'
    ];
    protected $table = 'rekap__fbcj';

    // default field
    private static $column_table = [
        'rekap__fbcj.id',
        'rekap__fbcj.nomor',
        'rekap__fbcj.id_unit_kerja_divisi',
        'rekap__fbcj.tanggal',
        'rekap__fbcj.kas_jurnal',
        'rekap__fbcj.id_cost_center',
        'rekap__fbcj.id_penandatangan',

    ];

    protected static $allow_limit = [10, 25, 50, 100];

    protected static $limit = 10;

    protected static $page = 1;

    protected static $total_row;

    public $timestamps = true;

    public static function getFbcj($request, $idFbcj = null)
    {

        try {

            $get = DB::table('rekap__fbcj')
                ->leftJoin('unit_kerja__divisi', 'rekap__fbcj.id_unit_kerja_divisi', '=', 'unit_kerja__divisi.id')
                ->leftJoin('karyawan', 'karyawan.id', '=', 'rekap__fbcj.id_penandatangan')
                ->leftJoin('lainnya__cost_center', 'rekap__fbcj.id_cost_center', '=', 'lainnya__cost_center.id');

            // add select dari join
            $addSelect = [
                'unit_kerja__divisi.nama_divisi',
                'unit_kerja__divisi.kode_divisi',
                'lainnya__cost_center.kode_cost_center',
                'lainnya__cost_center.nama_cost_center',
                'karyawan.nip AS nip_penandatangan',
                'karyawan.nama_karyawan AS nama_penandatangan',
                'karyawan.email AS nip_penandatangan',
            ];
            self::$column_table = array_merge($addSelect, self::$column_table);

            // request param di kirim ke 'self'
            self::$request = $request;
            $get = self::getParam($get);

            if ($idFbcj != null)
                $get = $get->where('rekap__fbcj.id', $idFbcj);
            // field yang ditampilkan
            $get = $get->get(self::$column_table);

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

    public static function getFbcjDetail($request, $idFbcj)
    {

        try {

            $get = DB::table('rekap__fbcj_detail')
                ->leftJoin('lainnya__bussiness_trans', 'lainnya__bussiness_trans.id', '=', 'rekap__fbcj_detail.id_bussiness_trans')
                ->leftJoin('lainnya__wbs_element', 'lainnya__wbs_element.id', '=', 'rekap__fbcj_detail.id_wbs_element')
                ->leftJoin('karyawan', 'karyawan.id', '=', 'rekap__fbcj_detail.id_karyawan')
                ->leftJoin('rekap__fbcj', 'rekap__fbcj.id', '=', 'rekap__fbcj_detail.id_fbcj');

            // add select dari join
            $addSelect = [
                'rekap__fbcj_detail.id',
                'lainnya__bussiness_trans.kode_bussiness_trans',
                'lainnya__bussiness_trans.nama_bussiness_trans',

                'lainnya__wbs_element.kode_wbs_element',
                'lainnya__wbs_element.nama_wbs_element',

                'karyawan.nama_karyawan',
                'rekap__fbcj_detail.doc_no',
                'rekap__fbcj_detail.amount'

            ];
            self::$column_table = $addSelect;

            // exit(1);
            $get = $get->where('rekap__fbcj_detail.id_fbcj', $idFbcj);
            // field yang ditampilkan
            $get = $get->get(self::$column_table);

            $response = [
                'status_code'    => 200,
                'message'        => 'ok',
                'limit'          => self::$limit,
                'total_row'      => $get->count(),
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

    public static function getFbcjSubDetail($request, $idFbcj)
    {

        try {

            $get = DB::table('rekap__fbcj_sub_detail')
                ->leftJoin('rekap__fbcj', 'rekap__fbcj.id', '=', 'rekap__fbcj_sub_detail.id_fbcj')
                ->leftJoin('rekap__fbcj_detail', 'rekap__fbcj_detail.id', '=', 'rekap__fbcj_sub_detail.id_fbcj_detail');

            // add select dari join
            $addSelect = [
                'rekap__fbcj_sub_detail.id',
                'rekap__fbcj_sub_detail.id_fbcj',
                'rekap__fbcj_sub_detail.id_fbcj_detail',
                'rekap__fbcj_sub_detail.keterangan',
                'rekap__fbcj_sub_detail.tanggal_bon',
                'rekap__fbcj_sub_detail.amount_detail',

            ];
            self::$column_table = $addSelect;

            // exit(1);
            $get = $get->where('rekap__fbcj_sub_detail.id_fbcj', $idFbcj);
            // field yang ditampilkan
            $get = $get->get(self::$column_table);

            $response = [
                'status_code'    => 200,
                'message'        => 'ok',
                'limit'          => self::$limit,
                'total_row'      => $get->count(),
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

    public static function getAutoNumber()
    {
        $text = '';
        $nomor = Fbcj::get()->count() + 1;
        if ($nomor <= 9) :
            $text = "0000000000{$nomor}";
        elseif ($nomor <= 99) :
            $text = "000000000{$nomor}";
        elseif ($nomor <= 999) :
            $text = "00000000{$nomor}";
        elseif ($nomor <= 9999) :
            $text = "00000000{$nomor}";
        elseif ($nomor <= 99999) :
            $text = "0000000{$nomor}";
        elseif ($nomor <= 999999) :
            $text = "000000{$nomor}";
        elseif ($nomor <= 9999999) :
            $text = "00000{$nomor}";
        elseif ($nomor <= 99999999) :
            $text = "0000{$nomor}";
        elseif ($nomor <= 999999999) :
            $text = "000{$nomor}";
        elseif ($nomor <= 9999999999) :
            $text = "00{$nomor}";
        elseif ($nomor <= 99999999999) :
            $text = "0{$nomor}";
        elseif ($nomor <= 999999999999) :
            $text = "{$nomor}";
        endif;

        return $text;
    }

    public static function getAutoNumberDetailFbcj()
    {
        $text = '';
        $nomor = DB::table('rekap__fbcj_detail')->get()->count() + 1;
        if ($nomor <= 9) :
            $text = "0000000000{$nomor}";
        elseif ($nomor <= 99) :
            $text = "000000000{$nomor}";
        elseif ($nomor <= 999) :
            $text = "00000000{$nomor}";
        elseif ($nomor <= 9999) :
            $text = "00000000{$nomor}";
        elseif ($nomor <= 99999) :
            $text = "0000000{$nomor}";
        elseif ($nomor <= 999999) :
            $text = "000000{$nomor}";
        elseif ($nomor <= 9999999) :
            $text = "00000{$nomor}";
        elseif ($nomor <= 99999999) :
            $text = "0000{$nomor}";
        elseif ($nomor <= 999999999) :
            $text = "000{$nomor}";
        elseif ($nomor <= 9999999999) :
            $text = "00{$nomor}";
        elseif ($nomor <= 99999999999) :
            $text = "0{$nomor}";
        elseif ($nomor <= 999999999999) :
            $text = "{$nomor}";
        endif;

        return $text;
    }

    protected static $request;


    public static function getParam($query)
    {
        $request = self::$request;
        if (isset($request['id'])) {
            $query = $query->where('rekap__fbcj.id', $request['id']);
        }

        if (isset($request['penandatangan']) && $request['penandatangan'] == 'yes') {
            self::$column_table = array_merge([
                DB::raw("(SELECT jabatan.nama_jabatan FROM jabatan WHERE jabatan.id = karyawan.id_jabatan) AS jabatan_penandatangan")
            ], self::$column_table);
        }


        if (isset($request['created_at'])) {
            $query = $query->where(DB::raw("DATE_FORMAT(rekap__fbcj.created_at,'%Y-%m-%d')"), $request['created_at']);
        }


        if (isset($request['created_at_bulan'])) {
            $query = $query->where(DB::raw("DATE_FORMAT(rekap__fbcj.created_at,'%Y-%m')"), $request['created_at_bulan']);
        }
        if (isset($request['created_at_tahun'])) {
            $query = $query->where(DB::raw("DATE_FORMAT(rekap__fbcj.created_at,'%Y')"), $request['created_at_tahun']);
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

            // kalo berdasarkan nama jabatan A-Z
            if ($request['order_by'] == 'fbcj_asc') {
                $query = $query->orderBy('rekap__fbcj.nomor', 'ASC');
            }
            // kalo berdasarkan nama jabatan Z-A
            elseif ($request['order_by'] == 'fbcj_desc') {
                $query = $query->orderBy('rekap__fbcj.nomor', 'DESC');
            } else {
                // settingan default order_by
                $query = $query->orderBy('rekap__fbcj.nomor', 'DESC');
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
