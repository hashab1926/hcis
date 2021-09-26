<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Provinsi extends Model
{
    protected $fillable = ['nama_provinsi'];
    protected $table = 'provinsi';

    // default field
    private static $column_table = [
        'id',
        'nama_provinsi'
    ];

    protected static $allow_limit = [10, 25, 50, 100];

    protected static $limit = 10;

    protected static $page = 1;

    protected static $total_row;

    public $timestamps = false;

    public static function getProvinsi($request)
    {

        try {

            $get = DB::table('provinsi');

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
                $query = $query->whereIn('provinsi.id', $explodeId);
            }
            // kalo param 'id' nya cuma 1
            else {

                $query = $query->where('provinsi.id', $request['id']);
            }
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

            // kalo berdasarkan nama provinsi A-Z
            if ($request['order_by'] == 'nama_provinsi_asc') {
                $query = $query->orderBy('provinsi.nama_provinsi', 'ASC');
            }
            // kalo berdasarkan nama provinsi Z-A
            elseif ($request['order_by'] == 'nama_provinsi_desc') {
                $query = $query->orderBy('provinsi.nama_provinsi', 'DESC');
            } else {
                // settingan default order_by
                $query = $query->orderBy('provinsi.nama_provinsi', 'ASC');
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
