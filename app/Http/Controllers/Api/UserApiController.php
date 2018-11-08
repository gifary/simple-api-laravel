<?php
/**
 * Created by PhpStorm.
 * User: gifary
 * Date: 11/6/18
 * Time: 12:54 PM
 */

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserApiController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email'  => 'required|email|exists:users',
            'password'   => 'required'
        ]);

        if($validator->fails()){
            return $this->sendResponse($validator->errors(),'Error',401);
        }

        //succes return token for access data
        $user = User::where('email',$request->email)->first();
        if(Hash::check($request->password,$user->password)) {
            $user['token'] =$user->createToken(getenv('APP_NAME'))->accessToken;
            return $this->sendResponse($user,'Success',200);
        } else{
            return $this->sendResponse('Wrong password','Error',401);
        }
    }
}
