<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task; //importar correctamente el modelo 
use Illuminate\Support\Facades\Auth; // es el controlador que deja autenticar el usuario

class TaskController extends Controller
{
    

    //get task info
    public function getTaskInfo($id){
        $task =  Task::find($id);
        if(!$task){
            return response()->json(['error' => 'task not found'], 404);
        }
        return response()-> json(['taskInfo' => $task]);
    }



    //get All task
    public function getUserTasks(Request $request)
    {
        $user = $request->user(); // obtiene el usuario actual autenticado a través del token enviado por el front
        $tasks = $user->tasks; // Cambia $user->task a $user->tasks
        return response()->json(['user_tasks' => $tasks], 200); // responde con las tareas
    }



    //crear task
    public function create_task(Request $request)
    {
        // obtener el encabezado que viene del front en la autorizacion
        $authorizationHeader = $request->header('Authorization');
        \Log::info('Authorization Header: '. $authorizationHeader); // log para ver que se envio en el header desde el front


        // verificar si el usuario esta autenticado
        if(Auth::check()){
            try{
                // obetener el usuario mediante el token
                $user = Auth::user();

                if($user){// si el usuario se encuentra autenticado
                    $task = new Task(); //crea el modelo como referencia    
                    $task->user_id = $user->id;
                    $task->name = $request->input('name');
                    $task->description = $request->input('description');
                    $task->status = $request->input('status');
                    $task->date = $request->input('date');
                    $task->save();

                    // respuesta indicando que se creo la task
                    return response()->json(['message' => 'Task created succesfully', 'task' => $task],201);
                }else {
                    return response()->json(['message' => 'Failed to create Task: user not found', 'task' => $task],404);
                }
            }catch (\Exception $e) {
                // Manejo de errores si ocurre alguna excepción al crear el task
                return response()->json(['message' => 'Failed to create savings', 'error' => $e->getMessage()], 500);
            }
        }else {
            // Si no hay un usuario autenticado
            return response()->json(['message' => 'Unauthenticated'], 401);
        }
    }


    //saveTask (edit)
    public function editTask(Request $request, $id){

        try{
            
            $user = Auth::user(); //usario autentificado
            $task = Task::find($id); // id de la task
    
            //no recibio nada
            if (!$task){
                return response()->json(['back error' => 'task not found'], 404);
            }
    
            //el task no pertence al usuario autenticado
            if($task->user_id !== $user->id){
                return response()->json(['back error' => 'Unauthorized'], 401);
            }
    
            //actulizar el task
            $task->name = $request->input('name');
            $task->description = $request->input('description');
            $task->status = $request->input('status');
            $task->date = $request->input('date');
            $task->save();
    
            return response()->json(['message' => 'Task updated successfully', 'task'=> $task],200);

        }catch(\Exception $e){

            return response()->json(['message' => 'Failed to update the task', 'back error'=> $e->getMessage()],500);
        } 
    }

    //change task status
    public function changeStatus (Request $request, $id){
        try{
            $user = Auth::user(); //usario autentificado
            $task = Task::find($id); // id de la task

             //no recibio nada
             if (!$task){
                return response()->json(['back error' => 'task not found'], 404);
            }

             //el task no pertence al usuario autenticado
             if($task->user_id !== $user->id){
                return response()->json(['back error' => 'Unauthorized'], 401);
            }

             //actulizar el status
             $task->status = $request->input('status');
             $task->save();

             return response()->json(['message' => 'status update successfully', 'task'=> $task],200);

        }catch(\Exception $e){
            return response()->json(['message' => 'Failed to change task status', 'back error'=> $e->getMessage()],500);
        } 
    }

    //delete task
    public function deleteTask($id){
        try {

            $task = Task::find($id);
 
            // No se encontró
            if (!$task) {
                return response()->json(['error' => 'Task not found'], 404);
            }

            // Elimina la tarea
            $task->delete();
    
    
    
           
    
            return response()->json(['message' => 'Task deleted successfully'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to delete task', 'error' => $e->getMessage()], 500);
        }
    }

}