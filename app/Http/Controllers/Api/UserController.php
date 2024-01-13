<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function index() {
        $user = Auth::user();
    
        $token = $user->currentAccessToken();

        return response()->json(['user' => $user, 'current_access_token' => $token]);
    }

    public function login(Request $request) {
        $dadosLogin = $request->only(['email','password', 'delete']);
        
        if(!count($dadosLogin) == 2 ) {
            return response()->json(
                [
                    "message" => "Informe o e-mail e o password para fazer o login"
                ],
                403
            );         
        }

        if ( Auth::attempt($dadosLogin) ) {
            $user = Auth::user();
            $user->tokens()->delete();
            $token = $user->createToken(
                'token_' . $user->name,
                ['read', 'edit', 'delete'],
                now()->add('hour', 1)
            );
            return response()->json(
                [
                    "token" => $token->plainTextToken
                ],
                201
            );  

        } else {
            return response()->json(
                [
                    "message" => "Não autorizado, informações de login incorretas"
                ],
                401
            );      
        }
    }

    public function register(StoreUserRequest $request) {
        $category = User::create($request->all());

        return response()->json(
            [
                "message" => "Usuário criado com sucesso",
                "id" => $category->id
            ],
            201
        );
    }
}
