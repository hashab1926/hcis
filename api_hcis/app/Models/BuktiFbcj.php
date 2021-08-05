<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class BuktiFbcj extends Model
{
    protected $fillable = ['id_fbcj', 'bukti_file'];
    protected $table = 'rekap__fbcj_bukti';
    // default field
    private static $column_table = [
        'id',
        'id_fbcj',
        'bukti_file'
    ];

    protected static $allow_limit = [10, 25, 50, 100];

    protected static $limit = 10;

    protected static $page = 1;

    protected static $total_row;

    public $timestamps = false;

    public static function getLampiran($idFbcj, $request)
    {

        try {

            $get = DB::table('rekap__fbcj_bukti');

            // request param di kirim ke 'self'
            self::$request = $request;
            $get = self::getParam($get);

            // by id_fbcj
            if ($idFbcj != null)
                $get->where('rekap__fbcj_bukti.id_fbcj', $idFbcj);

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
            $query = $query->where('rekap__fbcj_bukti.id', $request['id']);
        }

        // kalo ada param 'id_fbcj'
        if (isset($request['id_fbcj'])) {
            $query = $query->where('rekap__fbcj_bukti.id_fbcj', $request['id_fbcj']);
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
