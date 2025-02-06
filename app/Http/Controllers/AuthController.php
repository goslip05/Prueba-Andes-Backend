<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Models\User;

class AuthController extends Controller
{

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request)
    {
        //validar el request
        $data = $request->validated();


        //revisar el password
        if (!$token = Auth::attempt($data)) {
            return response([
                'errors' => ['El email o el Password son incorrectos']
            ], 401);
        }

        //llamado a la funcion para responder con el token
        return $this->respondWithToken($token);
    }


    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout(Request $request)
    {
        auth()->logout();

        return response()->json(['message' => '¡Has cerrado sesión exitosamente!'], 200, [], JSON_UNESCAPED_UNICODE);
    }


    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        $ttl = JWTAuth::factory()->getTTL();

        return response()->json([
            'message' => '¡Inicio de sesión exitoso!',
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => $ttl * 60
        ]);
    }

    public function register(RegisterRequest $request)
    {
        //validar el request
        $data = $request->validated();

        //crear el usuario
        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password'])
        ]);

        return response()->json([
            'message' => '!Usuario registrado exitosamente!',
            'user' => $user,
        ], 201);
    }
}
