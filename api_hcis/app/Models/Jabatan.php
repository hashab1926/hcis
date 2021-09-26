<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Jabatan extends Model
{
    protected $fillable = ['nama_jabatan', 'id_unit_kerja_bagian'];
    protected $table = 'jabatan';

    // default field
    private static $column_table = [
        'jabatan.id',
        'jabatan.nama_jabatan',
        'jabatan.id_unit_kerja_bagian'
    ];

    protected static $allow_limit = [10, 25, 50, 100];

    protected static $limit = 10;

    protected static $page = 1;

    protected static $total_row;

    public $timestamps = false;

    public static function getJabatan($request)
    {

        try {

            $get = DB::table('jabatan')
                ->leftJoin('unit_kerja__bagian', 'unit_kerja__bagian.id', '=', 'jabatan.id_unit_kerja_bagian');

            // request param di kirim ke 'self'
            self::$request = $request;
            $get = self::getParam($get);

            // add select dari join
            $addSelect = [
                'unit_kerja__bagian.nama_bagian',
            ];
            self::$column_table = array_merge($addSelect, self::$column_table);

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
                $query = $query->whereIn('jabatan.id', $explodeId);
            }
            // kalo param 'id' nya cuma 1
            else {

                $query = $query->where('jabatan.id', $request['id']);
            }
        }

        // kalo ada param q
        if (isset($request['q'])) {
            $q = $request['q'];
            $query = $query->where(function ($queryOr) use ($q) {
                $queryOr->orWhere('jabatan.nama_jabatan', 'like', "%$q%");
            });
        }

        if (isset($request['id_unit_kerja_bagian']))
            $query = $query->where('unit_kerja__bagian.id', $request['id_unit_kerja_bagian']);

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
            if ($request['order_by'] == 'nama_jabatan_asc') {
                $query = $query->orderBy('jabatan.nama_jabatan', 'ASC');
            }
            // kalo berdasarkan nama jabatan Z-A
            elseif ($request['order_by'] == 'nama_jabatan_desc') {
                $query = $query->orderBy('jabatan.nama_jabatan', 'DESC');
            } else {
                // settingan default order_by
                $query = $query->orderBy('jabatan.nama_jabatan', 'ASC');
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
