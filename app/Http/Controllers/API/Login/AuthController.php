<?php

namespace App\Http\Controllers\API\Login;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //
    public  function login(Request $request)
    {
        //
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try{
            $user = User::where('email', $request->email)->first();
            $role = $user->getRoleNames()->first();
            if(is_null($user))
                abort(400,' User not found');
            if(false == Auth::attempt(['email' => $request->email, 'password' => $request->password]))
                abort(400,' Invalid credentials');

            return response()->json([
                'header' => [
                    'token' => $user->createToken('67391a01156c5d94549b15dbcd99468b')->plainTextToken,
                    'code' => 200,
                    'message' => 'Success Login'
                ],
                'data' => [
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role,
                ]
            ]);
        }catch(Exception $e){
            return response()->json(['error' => $e->getMessage()], 401);
        }

    }

    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->where('id', $user->currentAccessToken()->id)->delete();
        return response()->json([
            'header' => [
                'code' => 200,
                'message' => 'Successfully logged out'
            ]
        ]);
    }
}
