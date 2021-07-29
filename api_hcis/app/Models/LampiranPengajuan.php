<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class LampiranPengajuan extends Model
{
    protected $fillable = ['id_pengajuan', 'bukti_file'];
    protected $table = 'lampiran_pengajuan';
    // default field
    private static $column_table = [
        'id',
        'id_pengajuan',
        'bukti_file'
    ];

    protected static $allow_limit = [10, 25, 50, 100];

    protected static $limit = 10;

    protected static $page = 1;

    protected static $total_row;

    public $timestamps = false;

    public static function getLampiran($idPengajuan, $request)
    {

        try {

            $get = DB::table('lampiran_pengajuan');

            // request param di kirim ke 'self'
            self::$request = $request;
            $get = self::getParam($get);

            // by id_pengajuan
            if ($idPengajuan != null)
                $get->where('lampiran_pengajuan.id_pengajuan', $idPengajuan);

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
            $query = $query->where('lampiran_pengajuan.id', $request['id']);
        }

        // kalo ada param 'id_pengajuan'
        if (isset($request['id_pengajuan'])) {
            $query = $query->where('lampiran_pengajuan.id_pengajuan', $request['id_pengajuan']);
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
