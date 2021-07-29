<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;

class Karyawan extends Model
{
    protected $fillable = [
        'nip',
        'nama_karyawan',
        'id_pangkat',
        'id_user',
        'id_unit_kerja_kepala',
        'id_unit_kerja_divisi',
        'id_unit_kerja_bagian',
        'id_jabatan',
        'email',
        'nomor_hp',
        'foto'
    ];

    protected $table = 'karyawan';

    // default field
    private static $column_table = [
        'karyawan.id',
        'karyawan.nip',
        'karyawan.nama_karyawan',
        'karyawan.id_user',
        'karyawan.id_pangkat',
        'karyawan.id_unit_kerja_kepala',
        'karyawan.id_unit_kerja_divisi',
        'karyawan.id_unit_kerja_bagian',
        'karyawan.id_jabatan',
        'karyawan.email',
        'karyawan.nomor_hp',
        'karyawan.foto',

    ];

    protected static $allow_limit = [10, 25, 50, 100];

    protected static $limit = 10;

    protected static $page = 1;

    protected static $total_row;

    public $timestamps = false;

    public static function getKaryawan($request)
    {

        try {
            $get = DB::table('karyawan')
                ->leftJoin('jabatan', 'jabatan.id', '=', 'karyawan.id_jabatan')
                ->leftJoin('pangkat', 'pangkat.id', '=', 'karyawan.id_pangkat')
                ->leftJoin('unit_kerja__kepala', 'unit_kerja__kepala.id', '=', 'karyawan.id_unit_kerja_kepala')
                ->leftJoin('unit_kerja__divisi', 'unit_kerja__divisi.id', '=', 'karyawan.id_unit_kerja_divisi')
                ->leftJoin('user', 'user.id', '=', 'karyawan.id_user')

                ->leftJoin('unit_kerja__bagian', 'unit_kerja__bagian.id', '=', 'karyawan.id_unit_kerja_bagian');

            // add select dari join
            $addSelect = [
                'user.level',
                'user.username',
                'jabatan.nama_jabatan',
                'pangkat.nama_pangkat',
                'unit_kerja__kepala.nama_kepala',
                'unit_kerja__divisi.nama_divisi',
                'unit_kerja__bagian.nama_bagian',
            ];
            self::$column_table = array_merge($addSelect, self::$column_table);
            // dd(self::$column_table);
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
                $query = $query->whereIn('karyawan.id', $explodeId);
            }

            // kalo param 'id' nya cuma 1
            else {

                $query = $query->where('karyawan.id', $request['id']);
            }
        }
        // kalo ada param status
        if (isset($request['status'])) {
            switch ($request['status']) {
                case 'biasa':
                    $query = $query->where('karyawan.status', '1');
                    break;
                case 'pejabat':
                    $query = $query->orWhere(function ($queryOr) {
                        $queryOr->orWhere('user.level', '3')
                            ->orWhere('user.level', 'DIR');
                    });
                    break;
                case 'not_register':
                    $query = $query->whereNull('karyawan.id_user');
                    break;

                case 'pengaju':
                    $query = $query->orWhere(function ($queryOr) {
                        $queryOr->orWhere('user.level', '1')
                            ->orWhere('user.level', '2')
                            ->orWhere('user.level', '3');
                    });
                    break;
            }
        }
        // kalo ada param q
        if (isset($request['q'])) {
            $q = $request['q'];
            $query = $query->where(function ($queryOr) use ($q) {
                $queryOr->orWhere('karyawan.nip', 'like', "%$q%")
                    ->orWhere('karyawan.nama_karyawan', 'like', "%$q%")
                    ->orWhere('pangkat.nama_pangkat', 'like', "%$q%")
                    ->orWhere('jabatan.nama_jabatan', 'like', "%$q%");
            });
        }



        // param 'order_by'
        $query = self::paramOrderBy($query);

        if (isset($request['id_unit_kerja_kepala'])) {
            $query = $query->where('id_unit_kerja_kepala', $request['id_unit_kerja_kepala']);
        }

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

            // kalo berdasarkan data terbaru
            if ($request['order_by'] == 'desc') {
                $query = $query->orderBy('id', 'DESC');
            } elseif ($request['order_by'] == 'asc') {
                $query = $query->orderBy('id', 'ASC');
            }
            // kalo berdasarkan nama karyawan A-Z
            elseif ($request['order_by'] == 'nama_karyawan_asc') {
                $query = $query->orderBy('karyawan.nama_karyawan', 'ASC');
            }
            // kalo berdasarkan nama karyawan Z-A
            elseif ($request['order_by'] == 'nama_karyawan_desc') {
                $query = $query->orderBy('karyawan.nama_karyawan', 'DESC');
            } else {
                // settingan default order_by
                $query = $query->orderBy('id', 'DESC');
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
