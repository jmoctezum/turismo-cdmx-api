<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\ExpiredException;

class Authenticate
{
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->header('Authorization');

        if (!$token) {
            return response()->json([
                'error' => 'Token no proporcionado.'
            ], 401);
        }

        if (strpos($token, 'Bearer ') !== false) {
            $token = str_replace('Bearer ', '', $token);
        }

        try {
            $credentials = JWT::decode($token, new Key(env('JWT_SECRET'), 'HS256'));
        } catch (ExpiredException $e) {
            return response()->json([
                'error' => 'Token expirado.'
            ], 401);
        } catch (Exception $e) {
            return response()->json([
                'error' => 'Error al decodificar el token: ' . $e->getMessage()
            ], 401);
        }

        $user = User::find($credentials->sub);

        if (!$user) {
            return response()->json([
                'error' => 'Usuario no encontrado.'
            ], 401);
        }

        // Añadir usuario a la solicitud
        $request->auth = $user;

        return $next($request);
    }
}
