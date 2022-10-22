<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function store(Request $request){
        
        $input= $request->all();
        $input['password']=Hash::make($request->password);
        User::create($input);
        return response()->json(['res' => true, 'message' => "User success"],200);
    }
    public function login(Request $request)
    {
        $user = User::whereEmail($request->email)->first();
        
        if (!is_null($user) && Hash::check($request->password, $user->password)) {

            $token = $user->createToken('user')->accessToken;
            return response()->json([
                'res' => true, 
                'token' => $token, 
                'message' => "Bienvenido al sistema"
            ]);
        } else
            return response()->json(['res' => false, 'message' => "Cuenta a password incorrectos"]);
    }
}
