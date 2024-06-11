<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notes;
use Illuminate\Support\Facades\Auth; // es el controlador que deja autenticar el usuario

class NotesController extends Controller
{
        //get note info
        public function getNoteInfo($id)
        {
            $note = Notes::find($id);
    
            if (!$note) {
                return response()->json(['error' => 'note not found'], 404);
            }
    
            return response()->json(['noteInfo' => $note]);
        }



        //get All notes
        public function getUserNotes(Request $request)
        {
            $user = $request->user(); // obtiene el usuario actual autenticado a través del token enviado por el front
            $notes = $user->notes; // Cambia $user->task a $user-notes
            return response()->json(['userNotes' => $notes], 200); // responde con las notas
        }   



        //crear notes
        public function createNotes(Request $request)
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
    
                        $notes = new Notes();
                        $notes->user_id = $user->id;
                        $notes->title = $request->input('title');
                        $notes->excerpt = $request->input('excerpt');
                        $notes->importance = $request->input('importance');
                        $notes->content = $request->input('content');
                        $notes->save();
    
                        // respuesta indicando que se creó el ahorro
                        return response()->json(['message' => 'notes created successfully', 'notes' => $notes], 201);
                    } else {
                        return response()->json(['message' => 'Failed to create notes: User not found'], 404);
                    }
                } catch (\Exception $e) {
                    // Manejo de errores si ocurre alguna excepción al crear el ahorro
                    return response()->json(['message' => 'Failed to create notes', 'error' => $e->getMessage()], 500);
                }
            } else {
                // Si no hay un usuario autenticado
                return response()->json(['message' => 'Unauthenticated'], 401);
            }
        }


        //Edit Notes
        public function editNotes(Request $request, $id)
        {
            try {
                $user = Auth::user();// usuario autentificado
                $note = Notes::find($id);// id de la nota

                if (!$note) {
                    return response()->json(['error' => 'Note not found'], 404);
                }

                // verifica que la nota pertence al usuario autenticado
                if ($note->user_id !== $user->id) {
                    return response()->json(['error' => 'Unauthorized'], 401);
                }

                // actualizar content
                $note->content = $request->input('content');
                $note->save();

                return response()->json(['message' => 'Note content updated successfully', 'note' => $note], 200);
            } catch (\Exception $e) {
                return response()->json(['message' => 'Failed to update note content', 'error' => $e->getMessage()], 500);
            }
        }
}
