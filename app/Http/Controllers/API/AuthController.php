<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        //

    }


    public function login(Request $request)
    {
        $validate = Validator::make($request->all(),[
            'email' => 'required|string|email',
            'password' => 'required',
            'device_name' => 'required',
        ]);

        if($validate->fails()){
            $httpStatus = 422;
            return responseFailed($validate->errors()->first(), $httpStatus);
        }

        $user = User::where('email', $request->email)->first();

        if(!$user){

           $message = 'Email is unavailable';
           return responseFailed($message);

        }elseif(!Hash::check($request->password, $user->password)){

           $message = 'Your password is incorrect';
           return responseFailed($message);

        }

        $token = $user->createToken($request->device_name)->plainTextToken;
        $message = 'success login !';
        $data = $this->getData($user, $token);

        return responseSuccess($message, $data);

    }

    public function checkProfile(Request $request){
        $user = $request->user();

        if(!$user){
            $message = 'Failed you are still not login';
            return responseFailed($message, 422);
        }

        $message = 'Success check profile';

        return responseSuccess($message, $user);
    }

    public function logout(Request $request){
        $user = $request->user();
        $message = 'Success Logout';
        $data = $user->currentAccessToken()->delete();

        return responseSuccess($message, $data);
    }

    private static function getData($user, $token){

        $data = [
            'user' => $user,
            'token' => $token,
            'type' => 'bearer'
        ];

        return $data;
    }
}
