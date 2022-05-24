<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public $successStatus = 200;
    public $response_json = [];
    protected $data = [];
    protected $request;

    public function __construct(Request $request){

        Log::channel('api')->info($request->all());
        $this->request = $request;
        $this->response_json['message'] = 'Success';
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccess(){
        $this->response_json['data'] = (object) $this->data;
        $this->response_json['status'] = 1;
        return response()->json($this->response_json, 200);
    }
    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseSuccessWithoutDataObject(){
        $this->response_json['status'] = 1;
        return response()->json($this->response_json, 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function responseError(){
        $this->response_json['data'] = (object)  $this->data;
        $this->response_json['status'] = 0;
        return response()->json($this->response_json, 200);
    }


    public function currentuser(){
        return Auth::guard('api')->check() ? Auth::guard('api')->user() : false;
    }

    public function getUserFromMobile($mobile = null){
        return User::where('mobile', $mobile ?? request('mobile'))->first();
    }

    public function userCollection($user){

        return collect([
            'id' => $user->id,
            'name' => $user->full_name ?? null,
            'first_name' => $user->first_name ?? null,
            'last_name' => $user->last_name ?? null,
            'email' => $user->email ?? null,
            'mobile' => $user->mobile,
            'is_active' => $user->is_active,
            'dob' => $user->date_of_birth,
            'gender' => $user->gender,
            'token' => $user->createToken('ask-group')->plainTextToken,
            'is_otp_verify' => (int) $user->is_otp_verify,
            'otp' => $user->otp,
        ]);
    }
}
