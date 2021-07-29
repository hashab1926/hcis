<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'page']);

        $get = User::getUser($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'username'    => $request->post('username'),
                'password'    => Hash::make($request->post('password')),
                'level'       => $request->post('level'),
            ];
            // insert
            $insertWithId = User::insertGetId($allowPost);

            // update karyaawn
            $idKaryawan = $request->post('id_karyawan');
            $karyawan = \App\Models\Karyawan::findorFail($idKaryawan);
            $karyawan->update([
                'id_user'    => $insertWithId,
            ]);
            $response = [
                'status_code' => 201,
                'message'     => 'data telah ditambahkan',
            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage(),
            ];
        } catch (QueryException $Error) {
            $response = [
                'status_code' => 400,
                'message'     => $Error->getMessage(),
            ];
        } finally {
            return response()->json($response);
        }
    }
    public function delete($id)
    {
        try {

            User::findOrFail($id)->delete();
            $response = [
                'status_code' => 200,
                'message'     => 'data telah dihapus',
            ];
        } catch (\Illuminate\Database\QueryException $error) {
            $response = [
                'status_code' => 400,
                'message'     => 'Sedang terjadi kesalahan, silahkan coba beberapa saat lagi',
            ];
        } catch (\Exception $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage(),
            ];
        } finally {
            return response()->json($response);
        }
    }

    public function update($id, Request $request)
    {
        try {
            // set tules
            // $this->rules($request);

            $old = User::findOrFail($id);
            $username = !empty($request->post('username')) ? $request->post('username') : $old->username;
            $password = !empty($request->post('password')) ? Hash::make($request->post('password')) : $old->password;
            $level = !empty($request->post('level')) ? $request->post('level') : $old->level;

            $old->update([
                'username'    => $username,
                'password'    => $password,
                'level'       => $level
            ]);

            $response = [
                'status_code' => 200,
                'message'     => 'Data telah diperbarui',
                'response'    => $old,
            ];
        } catch (QueryException $Error) {
            $response = [
                'status_code' => 400,
                'message'     => $Error->getMessage(),

            ];
        } catch (\Exception $Error) {
            $response = [
                'status_code' => 400,
                'message'     => $Error->getMessage(),
            ];
        } finally {
            return response()->json($response);
        }
    }
}


trait Rules
{
    private $message = [
        'required'              => ':attribute harus diisi',
        'username.max'          => 'kolom username maksimal 100 karakter',
        'password.min'          => 'password minimal 8 karakter',
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'username'    => 'required|max:100',
            'password'    => 'required|min:8',
            'id_karyawan' => 'required|max:10',
            'level'       => 'required'
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
