<?php

namespace App\Http\Controllers;

use DB, JWTAuth, Validator, RestApi;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $user = User::where(function($q) use ($request) {
                if(strtolower($request->search) == 'aktif') {
                    $q->where('active', '1');
                }else if(strtolower($request->search) == 'tidak'){
                    $q->where('active', '0');
                }else{
                    $q->where('nik', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('name', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('email', 'LIKE', '%'.$request->search.'%');
                }
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            $user->map(function($a) {
                $a->action = '<button class="btn btn-sm btn-primary detail" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-eye"></i> Detail</button>';
                 // <button class="btn btn-sm btn-danger delete" title="Detail" data-id="'.$a->uuid.'"><i class="fa fa-trash"></i> Hapus</button>
                switch ($a->active) {
                    case 0:
                        $a->active = '<span class="label label-lg label-light-danger label-inline">TIDAK</span>';
                        break;

                    case 1:
                        $a->active = '<span class="label label-lg label-light-success label-inline">AKTIF</span>';
                        break;

                    case 2:
                        $a->active = '<span class="label label-lg label-light-success label-inline">-</span>';
                        break;
                }
                return $a;
            });

            return response()->json($user);

        }else{
            abort(404);
        }
    }

    public function detail(Request $request, $uuid)
    {
        if (request()->wantsJson() && request()->ajax()) {
            
            $user = User::findByUuid($uuid, 'Province', 'City');

            if(!isset($user->id)) {
                return RestApi::error('User tidak ditemukan.', 404);
            }
            
            return RestApi::success($user, 200, "Get Detail User Success.");
        }else{
            abort(404);
        }
    }

    public function updateProfile(Request $request)
    {
        $rules = [
            'name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'gender' => 'required|in:0,1',
            'birth_place' => 'required',
            'birth_date' => 'required|date_format:Y-m-d',
            'instansi' => 'required',
            'jabatan' => 'required',
            'province_id' => 'required',
            'city_id' => 'required',
            'nik' => 'required|min:16|max:16',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $user = User::find(JWTAuth::user()->id);

        if(!isset($user->id)) {
            return RestApi::error('User tidak ditemukan.', 404);
        }

        $user->address = $request->address;
        $user->birth_date = $request->birth_date;
        $user->birth_place = $request->birth_place;
        $user->city_id = $request->city_id;
        $user->gender = $request->gender;
        $user->instansi = $request->instansi;
        $user->jabatan = $request->jabatan;
        $user->nik = $request->nik;
        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->province_id = $request->province_id;

        if ($user->update()) {
            return RestApi::success('Berhasil mengubah profile!', 200);
        }else{
            return RestApi::error('Sesuatu error terjadi.', 500);
        }
    }

	public function changePassword(Request $request)
	{
        $rules = [
            'old_password' => 'required|string',
            'password' => 'required|string|confirmed|min:6',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $user = User::find(JWTAuth::user()->id);

        if(!isset($user->id)) {
        	return RestApi::error('User tidak ditemukan.', 404);
        }
        
        if(!Hash::check($request->old_password, $user->password)) {
            return RestApi::error('Password lama salah.', 400);
        }


        $user->password = bcrypt($request->password);

        if($user->update()) {
        	return RestApi::success('Berhasil ubah password.');
        }else{
        	return RestApi::error('Sesuatu error terjadi.', 500);
        }
	}

    public function rwpn(Request $request)
    {
        $rules = [
            'n' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return RestApi::error($validator->messages()->first(), 400);
        }

        $phone = $this->parsePhone($request->n);

        $user = User::where('phone', $phone)->first();

        if(!isset($user->id)) {
            return RestApi::error('Nomor tidak ditemukan.', 404);
        }

        if ($user->delete()) {
            return RestApi::success(null, 200, 'Berhasil menghapus nomor.');
        }
    }

    private function parsePhone($number=null)
    {
        if($number == null) {
            return $number;
        }

        $number = str_replace(" ","",$number);
        $number = str_replace("'","",$number);
        $number = str_replace("\"","",$number);
        $number = str_replace("-","",$number);
        $number = str_replace("(","",$number);
        $number = str_replace("*","",$number);
        $number = str_replace("^","",$number);
        $number = str_replace(")","",$number);
        $number = str_replace(".","",$number);
        $number = str_replace(",","",$number);
        $number = str_replace("/","",$number);
        $number = str_replace("?","",$number);

        $number = preg_replace('/[a-z]/i', '', $number);
        // dd($number);
        preg_match_all('!\d+!', $number, $no);
        $no = $no[0][0];


        $phone = null;


        // 0 TO 62
     //     if(substr(trim($no), 0, 2)=='62'){
     //     $phone = trim($no);
     //     }elseif(substr(trim($no), 0, 1)=='0'){
     //     $phone = '62'.substr(trim($no), 1);
        // }elseif(substr(trim($no), 0, 1)=='+'){
     //     $phone = substr(trim($no), 1);
        // }

        // 62 TO 0
        if(substr(trim($no), 0, 1)=='0'){
            $phone = trim($no);
        }elseif(substr(trim($no), 0, 2)=='62'){
            $phone = '0'.substr(trim($no), 2);
        }elseif(substr(trim($no), 0, 3)=='+62'){
            $phone = '0'.substr(trim($no), 3);
        }

        return $phone;
    }

    public function forTopic(Request $request)
    {
        if (request()->wantsJson() && request()->ajax()) {

            $per = (($request->per) ? $request->per : 10);
            $page = (($request->page) ? $request->page-1 : 0);
            
            DB::statement(DB::raw('set @angka=0+'.$page*$per));
            $user = User::where(function($q) use ($request) {
                if (strtolower($request->search) == 'aktif') {
                    $q->where('active', '1');
                } else if (strtolower($request->search) == 'tidak'){
                    $q->where('active', '0');
                } else {
                    $q->where('nik', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('name', 'LIKE', '%'.$request->search.'%')
                    ->orWhere('email', 'LIKE', '%'.$request->search.'%');
                }
            })->where(function ($q) use ($request) {
                if (isset($request->includes)) {
                    $q->whereIn('uuid', $request->includes);
                }
            })->orderBy('id','asc')->paginate($per, ['*', DB::raw('@angka  := @angka  + 1 AS angka')]);

            if (!$request->includes) {
                $user->map(function($a) {
                    $a->action = '<button class="btn btn-sm btn-icon btn-light-primary check" type="button" title="Check" data-id="'.$a->uuid.'"><i class="fa fa-check"></i></button>';
                    return $a;
                });
            }

            return response()->json($user);

        } else {
            abort(404);
        }
    }
}
