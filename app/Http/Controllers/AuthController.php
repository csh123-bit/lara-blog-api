<?php

namespace App\Http\Controllers;
use illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;

class AuthController extends Controller
{
    public function signUp(Request $request){
        // $validator = Validator::Make($request->all(),[
        //     'name'=>'required',
        //     'email'=>'required',
        //     'password'=>'required',
        //     'password_confirmation'=>'required',
        // ]);

        // if($validator->fails()){
        //     return response()->json(['message'=>'폼 검증 실패'],422);
        // }

        $params = $request->only(['name','email','password']);
        $params['password'] = bcrypt($params['password']);
        $user = User::create($params);
        return response()->json($user);

    }

    public function signIn(Request $request ){
        $params = $request->only(['email','password']);
        if(Auth::attempt($params)){
            $user=User::where('email',$params['email'])->first();
            $token = $user->createToken(env('APP_KEY'));
            return response()->json([
                'user'=>$user,
                'token'=>$token->plainTextToken,
            ]);
        }else{
            return response()->json(['message'=>'로그인 정보를 확인하세요.'],400);
        }
        return response()->json(Auth::attempt($params));
    }
}
