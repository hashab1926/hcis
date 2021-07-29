<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class UnitKerjaBagian extends Model
{
    protected $fillable = ['id_unit_kerja_divisi', 'kode_bagian', 'nama_bagian'];
    protected $table = 'unit_kerja__bagian';

    // default field
    private static $column_table = [
        'unit_kerja__bagian.id',
        'unit_kerja__bagian.id_unit_kerja_divisi',
        'unit_kerja__bagian.kode_bagian',
        'unit_kerja__bagian.nama_bagian'
    ];

    protected static $allow_limit = [10, 25, 50, 100];

    protected static $limit = 10;

    protected static $page = 1;

    protected static $total_row;

    public $timestamps = false;

    public static function getUnitKerjaBagian($request)
    {

        try {

            $get = DB::table('unit_kerja__bagian')->leftJoin('unit_kerja__divisi', 'unit_kerja__divisi.id', '=', 'unit_kerja__bagian.id_unit_kerja_divisi');

            // add select dari join
            $addSelect = [
                'unit_kerja__divisi.kode_divisi',
                'unit_kerja__divisi.nama_divisi',

            ];
            self::$column_table = array_merge($addSelect, self::$column_table);

            // request param di kirim ke 'self'
            self::$request = $request;
            $get = self::getParam($get);

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

    protected static $request;


    public static function getParam($query)
    {
        $request = self::$request;

        if (isset($request['id'])) {
            $explodeId = explode(',', $request['id']);

            // kalo param 'id' nya muliple
            if (is_array($explodeId) && count($explodeId) > 0) {
                $query = $query->whereIn('unit_kerja__bagian.id', $explodeId);
            }
            // kalo param 'id' nya cuma 1
            else {

                $query = $query->where('unit_kerja__bagian.id', $request['id']);
            }
        }

        if (isset($request['id_unit_kerja_divisi'])) {
            $query = $query->where('id_unit_kerja_divisi', $request['id_unit_kerja_divisi']);
        }

        // set 'total_row'
        self::$total_row = $query->count();

        // pagination
        $query = self::pagination($query);
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
