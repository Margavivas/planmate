<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\SavingsController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\NotesController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// registro y login de usuario
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout']);

//get user info
Route::middleware('auth:sanctum')->get('/login', [LoginController::class, 'getUserInfo']);

//create and get savings in dashboard (todas)
Route::middleware('auth:sanctum')->post('/savings', [SavingsController::class, 'create']);//ruta para crear un saving auth:sanctum se tiene que usar cuando se hace mmodificaciones con authenticacion
Route::middleware('auth:sanctum')->get('/savings', [SavingsController::class, 'fetchUserSavings']); // ruta para obtener los savings de los usuarios
// get specific Saving info
Route::get('/savings/{id}', [SavingsController::class, 'getSavingsInfo']);
// put ( editar nota) specific note info
Route::middleware('auth:sanctum')->put('/savings/{id}', [SavingsController::class, 'editSavings']); // edita la nota especifica

//create Task and get task in dashboard (todas)
Route::middleware('auth:sanctum')->post('/task', [TaskController::class, 'create_task']);//ruta para crear un task
Route::middleware('auth:sanctum')->get('/task', [TaskController::class, 'getUserTasks']); // ruta para obtener los savings de los usuarios
// get specific Task info
Route::get('/task/{id}', [TaskController::class, 'getTaskInfo']);
// put (editar task) specific
Route::middleware('auth:sanctum')->put('/task/{id}', [TaskController::class, 'editTask']); // edita la nota especifica
// put (change status) specific
Route::middleware('auth:sanctum')->put('/task/{id}/change-status', [TaskController::class, 'changeStatus']);// edita el status de la nota especifica
//delete task
Route::delete('/task/{id}', [TaskController::class, 'deleteTask']);// delete task




//create Notes y get de notes in dashboard (todas)
Route::middleware('auth:sanctum')->post('/notes', [NotesController::class, 'createNotes']);//ruta para crear un note
Route::middleware('auth:sanctum')->get('/notes', [NotesController::class, 'getUserNotes']); // obtiene todas las notas
// get specific note info
Route::get('/notes/{id}', [NotesController::class, 'getNoteInfo']);
// put ( editar nota) specific note info
Route::middleware('auth:sanctum')->put('/notes/{id}', [NotesController::class, 'editNotes']); // edita la nota especifica