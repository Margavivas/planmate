<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        // Crear un nuevo usuario
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if (!$user) {
            throw ValidationException::withMessages([
                'registration_error' => 'Failed to register user',
            ]);
        }

        // Generar un token para el usuario recién registrado
        $token = $user->createToken('AuthToken')->plainTextToken;

        // Devolver el token junto con otros datos en la respuesta JSON
        return response()->json([
            'message' => 'User registered successfully',
            'userId' => $user->id,
            'name' => $user->name,
            'token' => $token, // Agregar el token a la respuesta
        ], 201);
    }
}

