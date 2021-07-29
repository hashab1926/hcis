<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class BussinessTrans extends Model
{
    protected $fillable = ['kode_bussiness_trans', 'nama_bussiness_trans'];
    protected $table = 'lainnya__bussiness_trans';

    // default field
    private static $column_table = [
        'id',
        'kode_bussiness_trans',
        'nama_bussiness_trans'
    ];

    private static $allow_limit = [10, 25, 50, 100];

    private static $limit = 10;

    private static $page = 1;

    private static $total_row;

    private static $request;

    public $timestamps = false;

    public static function getBussinessTrans($request)
    {

        try {

            $get = DB::table('lainnya__bussiness_trans');

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


    public static function getParam($query)
    {
        $request = self::$request;

        if (isset($request['id'])) {
            $explodeId = explode(',', $request['id']);

            // kalo param 'id' nya muliple
            if (is_array($explodeId) && count($explodeId) > 0) {
                $query = $query->whereIn('lainnya__bussiness_trans.id', $explodeId);
            }
            // kalo param 'id' nya cuma 1
            else {

                $query = $query->where('lainnya__bussiness_trans.id', $request['id']);
            }
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
