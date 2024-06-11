<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Savings;
use Illuminate\Support\Facades\Auth;

class SavingsController extends Controller
{


    
    //get savings info
    public function getSavingsInfo($id){
        $saving =  Savings::find($id);
        if(!$saving){
            return response()->json(['error' => 'saving not found'], 404);
        }
        return response()-> json(['savingInfo' => $saving]);
    }


    //obtener los savings de los usuarios ALL
    public function fetchUserSavings(Request $request)
    {
        $user = $request->user(); // obtiene el usuario actual autenticado a traves del token enviado por el front
        $savings = $user->savings; // obtiene el ahorro del usuario autentificado
        return response()->json(['savings' => $savings], 200); // responde con los savings
    }

    //crear savings
    public function create(Request $request)
    {
        // Obtener el encabezado de autorización
            $authorizationHeader = $request->header('Authorization');
            // Imprimir o registrar el encabezado en los logs para verificar
            \Log::info('Authorization Header: ' . $authorizationHeader);
            
        // Verificar si el usuario está autenticado
        if (Auth::check()) {
            try {
                // Obtener el usuario autenticado mediante el token
                $user = Auth::user();

                if ($user) {
                    //Crear un ahorro asociado al usuario autenticado

                    $savings = new Savings();
                    $savings->user_id = $user->id;
                    $savings->name = $request->input('name');
                    $savings->amount = $request->input('amount');
                    $savings->goal = $request->input('goal');
                    $savings->deadline = $request->input('deadline');
                    $savings->save();

                    // respuesta indicando que se creó el ahorro
                    return response()->json(['message' => 'Savings created successfully', 'savings' => $savings], 201);
                } else {
                    return response()->json(['message' => 'Failed to create savings: User not found'], 404);
                }
            } catch (\Exception $e) {
                // Manejo de errores si ocurre alguna excepción al crear el ahorro
                return response()->json(['message' => 'Failed to create savings', 'error' => $e->getMessage()], 500);
            }
        } else {
            // Si no hay un usuario autenticado
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    }

    //edit Savings
    public function editSavings(Request $request, $id){

        try{

            $user = Auth::user(); //usario autentificado
            $saving = Savings::find($id); // id de la task
    
            //no recibio nada
            if (!$saving){
                return response()->json(['back error' => 'saving not found'], 404);
            }
    
            //el task no pertence al usuario autenticado
            if($saving->user_id !== $user->id){
                return response()->json(['back error' => 'Unauthorized'], 401);
            }
    
            //actulizar el task
            $saving->name = $request->input('name');
            $saving->amount = $request->input('amount');
            $saving->goal = $request->input('goal');
            $saving->deadline = $request->input('deadline');
            $saving->save();

            return response()->json(['message' => 'saving update successfully', 'task'=> $saving],200);

        }catch(\Exception $e){

            return response()->json(['message' => 'Failed to update the saving', 'back error'=> $e->getMessage()],500);
        } 
    }
}
