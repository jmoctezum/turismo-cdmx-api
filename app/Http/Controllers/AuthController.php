<?php

namespace App\Http\Controllers;

use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Registro de un nuevo usuario
     */
    public function register(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();

            // Crear token para el nuevo usuario
            $token = $this->generateJwtToken($user);

            return response()->json([
                'status' => 'success',
                'message' => 'Usuario registrado exitosamente',
                'user' => $user,
                'token' => $token
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error al registrar usuario',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Inicio de sesión de usuario
     */
    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        try {
            // Buscar usuario por email
            $user = User::where('email', $request->input('email'))->first();

            if (!$user || !Hash::check($request->input('password'), $user->password)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Credenciales inválidas'
                ], 401);
            }

            // Generar token JWT
            $token = $this->generateJwtToken($user);

            return response()->json([
                'status' => 'success',
                'message' => 'Inicio de sesión exitoso',
                'user' => $user,
                'token' => $token
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Error en inicio de sesión',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener información del usuario actual
     */
    public function me(Request $request)
    {
        return response()->json($request->auth);
    }

    /**
     * Generar token JWT
     */
    private function generateJwtToken($user)
    {
        $payload = [
            'iss' => "turismo-cdmx-api", // emisor
            'sub' => $user->id, // sujeto (ID de usuario)
            'iat' => time(), // emitido en
            'exp' => time() + env('JWT_EXPIRATION', 86400) // expiración (1 día por defecto)
        ];

        return JWT::encode($payload, env('JWT_SECRET'), 'HS256');
    }
}
