<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Lumen\Auth\Authorizable;

class User extends Model implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasFactory;
    protected $fillable = ['username', 'id_karyawan', 'level', 'password'];
    protected $table = 'user';

    // default field
    private static $column_table = [
        'user.id',
        'user.username',
        'user.level'
    ];

    protected static $allow_limit = [10, 25, 50, 100];

    protected static $limit = 10;

    protected static $page = 1;

    protected static $total_row;

    public $timestamps = false;

    public static function getUser($request = null)
    {

        try {

            $get = DB::table('karyawan')
                ->leftJoin('user', 'karyawan.id_user', '=', 'user.id')
                ->leftJoin('jabatan', 'jabatan.id', '=', 'karyawan.id_jabatan')
                ->leftJoin('pangkat', 'pangkat.id', '=', 'karyawan.id_pangkat')
                ->leftJoin('unit_kerja__kepala', 'unit_kerja__kepala.id', '=', 'karyawan.id_unit_kerja_kepala')
                ->leftJoin('unit_kerja__divisi', 'unit_kerja__divisi.id', '=', 'karyawan.id_unit_kerja_divisi')
                ->leftJoin('unit_kerja__bagian', 'unit_kerja__bagian.id', '=', 'karyawan.id_unit_kerja_bagian');


            $addSelect = [
                'karyawan.id AS id_karyawan',
                'karyawan.nip',
                'karyawan.nama_karyawan',
                'karyawan.id_jabatan',
                'karyawan.id_pangkat',
                'karyawan.id_user',
                'karyawan.nomor_hp',
                'karyawan.id_unit_kerja_kepala',
                'karyawan.id_unit_kerja_divisi',
                'karyawan.id_unit_kerja_bagian',
                'karyawan.status',
                'jabatan.nama_jabatan',
                'pangkat.nama_pangkat',
                'unit_kerja__kepala.nama_kepala',
                'unit_kerja__kepala.kode_kepala',
                'unit_kerja__divisi.nama_divisi',
                'unit_kerja__divisi.singkatan',
                'unit_kerja__divisi.kode_divisi',
                'unit_kerja__bagian.nama_bagian',

            ];
            self::$column_table = array_merge($addSelect, self::$column_table);

            // request param di kirim ke 'getParam'
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
            $query = $query->where('user.id', $request['id']);
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
