<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register']]);
    }

    /**
     * Get a JWT token via given credentials.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
    
        // Verificar si el correo electrónico está registrado
        $user = User::where('email', $credentials['email'])->first();
    
        if (!$user) {
            return response()->json(['error' => 'No hay ningún usuario registrado con ese correo electrónico'], 404, [], JSON_UNESCAPED_UNICODE);
        }
    
        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Credenciales incorrectas'], 401);
        }
    
        return $this->respondWithToken($token);
    }
    

    /**
     * Get the authenticated User
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json($this->guard()->user());
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
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken($this->guard()->refresh());
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
        
    public function register(Request $request)
    {        
        $validator = $this->validateInput($request->all());

        if (!is_array($validator)) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password)
            ]);  
            
            return response()->json([
                'message' => '!Usuario registrado exitosamente!',
                'user' => $user,                
            ],201, [], JSON_UNESCAPED_UNICODE);

        } else {
            return response()->json($validator,400, [], JSON_UNESCAPED_UNICODE);
        }
    }

    public function validateInput($parameters)
    {
        $response = [];
        $messages = [
            'max' => 'El campo :attribute no debe tener más de :max caracteres.',
            'required' => 'El campo :attribute no debe de estar vacío.',
            'min' => 'El campo :attribute no debe tener menos de :min caracteres.',
        ];

        $attributes = [
            'name' => 'nombre',
            'email' => 'correo electrónico',
            'password' => 'contraseña',
        ];

        $validation = Validator::make(
            $parameters,
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:100|unique:users,email',
                'password' => 'required|string|min:6',
            ],
            $messages,
            $attributes
        );

        // Para saber si falla la validación, nos retorne el estado y qué error se generó
        if ($validation->fails()) {
            array_push($response, ['status' => 'error']);
            array_push($response, ['errors' => $validation->errors()]);
            return $response;
        } else {
            return true;
        }
    }
}