<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\User;
use Illuminate\Http\Request;
use Firebase\JWT\JWT;

use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    use Rules;

    public function authLogin(Request $request)
    {

        try {
            // validation
            $this->rules($request);

            $username = $request->post('username');
            $password = $request->post('password');

            // cek username
            $cekLogin = User::select('id', 'password')->where('username', '=', $username)->first();

            // cek ada ga usernamenya 
            if ($cekLogin == null)
                throw new \Exception('Username tidak terdaftar');

            // cek password 
            if (!Hash::check($password, $cekLogin->password))
                throw new \Exception('Password yang anda masukan salah');


            // payload
            $payload =     [
                'sub' => $cekLogin->id,
                'iat' => time(),
                'exp' => time() + (3600 * 5) // token kadaluwarsa setelah 5 jam
            ];

            // Generate token
            $generateToken = JWT::encode($payload, env('APP_KEY'));

            // set mesasge 
            $response = [
                'status_code' => 200,
                'access_token' => $generateToken
            ];
        } catch (\Exception $error) {
            $response = [
                'status_code' => $error->getCode(),
                'message' => $error->getMessage()
            ];
        } catch (\Throwable $error) {
            $response = [
                'status_code' => 400,
                'message' => $error->getMessage()
            ];
        } finally {
            return response()->json($response);
        }
    }
}

trait Rules
{
    private $message = [
        'required'       => ':attribute harus diisi',
        'password.min'   => 'kolom password minimal 8 karakter'
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'username'  => 'required|max:100',
            'password'  => 'required|max:255|min:8',
        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
