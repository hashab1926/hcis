<?php

namespace App\Http\Controllers;

use Validator;

use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Hash;
use App\Helpers\BlobHelper;

class KaryawanController extends Controller
{

    use Rules;

    public function index(Request $request)
    {
        $allowGet = $request->only(['id', 'limit', 'q', 'page', 'order_by', 'status', 'id_user', 'status']);

        $get = Karyawan::getKaryawan($allowGet);
        return response()->json($get);
    }

    public function store(Request $request)
    {
        try {
            // set tules
            $this->rules($request);

            $allowPost = [
                'nip'                   => $request->post('nip'),
                'nomor_hp'              => $request->post('nomor_hp'),
                'nama_karyawan'         => $request->post('nama_karyawan'),
                'id_pangkat'            => $request->post('id_pangkat'),
                'id_unit_kerja_kepala'  => $request->post('id_unit_kerja_kepala'),
                'id_unit_kerja_divisi'  => $request->post('id_unit_kerja_divisi'),
                'id_unit_kerja_bagian'  => $request->post('id_unit_kerja_bagian'),
                'id_jabatan'            => $request->post('id_jabatan'),
                'email'                 => $request->post('email'),
                'status'                => $request->post('status') ?? '1'
            ];

            $filePhoto = $request->file('foto') ?? null;

            // cek 'foto'
            if ($request->hasFile('foto'))
                $allowPost['foto'] = BlobHelper::fileToBlob($filePhoto);

            $cariNip = Karyawan::where('nip', '=', $request->post('nip'))->count();
            if ($cariNip > 0)
                throw new \Exception("Nomor induk Telah digunakan, silahkan gunakan nomor induk lain");
            // insert
            Karyawan::create($allowPost);

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
            Karyawan::findOrFail($id)->delete();
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

    public function multipleDelete(Request $request)
    {
        try {
            $listIdKaryawan = json_decode($request->post('id_karyawan'), true);

            if (!is_array($listIdKaryawan) || count($listIdKaryawan) <= 0)
                throw new \Exception('Karyawan tidak ditemukan');

            Karyawan::whereIn('id', $listIdKaryawan)->delete();
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

            $old = Karyawan::findOrFail($id);
            $nip = !empty($request->post('nip')) ? $request->post('nip') : $old->nip;
            $nama = !empty($request->post('nama_karyawan')) ? $request->post('nama_karyawan') : $old->nama_karyawan;
            $idPangkat = !empty($request->post('id_pangkat')) ? $request->post('id_pangkat') : $old->id_pangkat;
            $idUnitKerjaKepala = !empty($request->post('id_unit_kerja_kepala')) ? $request->post('id_unit_kerja_kepala') : $old->id_unit_kerja_kepala;
            $idUnitKerjaDivisi = !empty($request->post('id_unit_kerja_divisi')) ? $request->post('id_unit_kerja_divisi') : $old->id_unit_kerja_divisi;
            $idUnitKerjaBagian = !empty($request->post('id_unit_kerja_bagian')) ? $request->post('id_unit_kerja_bagian') : $old->id_unit_kerja_bagian;
            $idJabatan = !empty($request->post('id_jabatan')) ? $request->post('id_jabatan') : $old->id_jabatan;
            $email = !empty($request->post('email')) ? $request->post('email') : $old->email;
            $noHp = !empty($request->post('nomor_hp')) ? $request->post('nomor_hp') : $old->nomor_hp;

            // kalo ada id_user
            $idUser = @$request->post('id_user');
            if (!empty($request->post('id_user')) || $request->post('id_user') != null) {
                $user =  \App\Models\User::findOrFail($idUser);
                $password = !empty($request->post('password')) ? Hash::make($request->post('password')) : $user->password;
                // throw new \Exception($password);
                $user->update([
                    'password'  => $password,
                    'level'     => $request->post('level')
                ]);
            }

            $allowUpdate = [
                'nip'                  => $nip,
                'nama_karyawan'        => $nama,
                'id_pangkat'           => $idPangkat,
                'id_unit_kerja_kepala' => $idUnitKerjaKepala,
                'id_unit_kerja_divisi' => $idUnitKerjaDivisi,
                'id_unit_kerja_bagian' => $idUnitKerjaBagian,
                'id_jabatan'           => $idJabatan,
                'email'                => $email,
                'nomor_hp'             => $noHp,

            ];

            // cek 'foto'
            if ($request->hasFile('foto')) {
                $filePhoto = $request->file('foto') ?? null;
                $allowUpdate['foto'] = BlobHelper::fileToBlob($filePhoto);
            }

            $old->update($allowUpdate);

            $response = [
                'status_code' => 200,
                'message'     => 'Data telah diperbarui',
                'response'    => $old,
            ];
        } catch (QueryException $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage(),

            ];
        } catch (\Exception | \Throwable $error) {
            $response = [
                'status_code' => 400,
                'message'     => $error->getMessage() . $error->getLine(),
            ];
        } finally {
            return response()->json($response);
        }
    }
}


trait Rules
{
    private $message = [
        'required'          => ':attribute harus diisi',
        'nama_karyawan.max' => 'nama karyawan maksimal 100 karakter'
    ];

    public function rules(Request $request)
    {
        $rules = Validator::make($request->post(), [
            'nip'            => 'required|max:100',
            'id_pangkat'     => 'required|max:10',
            'id_jabatan'     => 'required|max:10',

        ], $this->message);
        // cek rules
        if ($rules->fails())
            throw new \Exception($rules->errors()->first());
    }
}
