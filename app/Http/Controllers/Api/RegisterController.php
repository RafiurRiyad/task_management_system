<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Laravel\Passport\Token;
use Illuminate\Http\Request;
use Laravel\Passport\RefreshToken;
use Illuminate\Support\Facades\Auth;
use Validator;
use App\Http\Controllers\Api\BaseController as BaseController;

class RegisterController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
            'c_password' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['is_admin'] = 0;
        $user = User::create($input);

        return $this->login($request);
    }

    public function login(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $token =  $user->createToken('MyApp')->accessToken;

            return $this->respondWithToken($token);
        }
        else{ 
            return response()->json(['error' => 'Email or Password is not matched.'], 401);

        } 

    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::user()->AauthAcessToken()->delete();
        }

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function me(Request $request)
    {
        $user = $request->user();
        return response()->json(['user' => $user], 200);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            //'expires_in' => auth()->factory()->getTTL() * 60,
            'name' => auth()->user()->name,
            'user_id' => auth()->user()->id,
            'email' => auth()->user()->email,
        ]);
    }
}
