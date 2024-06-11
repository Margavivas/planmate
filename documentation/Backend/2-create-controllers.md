# Creacion de Controles
hay que crear la ruta en api.php dentro del directorio routes
y crear el archivo controladores para que estos puedan afectar a al modelo que 
se creo previamente.

## PASOS A SEGUIR 
- 1) Creacion del archivo controller
- 
    se crea en app/http/controllers
    puedes crearlo manualmente o hacer este comando
    php artisan make:controller SavingsController

    ```php
    <?php
        namespace App\Http\Controllers;
        use Illuminate\Http\Request;
        use App\Models\Savings; // importar correctamente el modelo Savings
        use Illuminate\Support\Facades\Auth; // es el controlador que deja autenticar el usuario

        class SavingsController extends Controller
        {
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
        }
    ```

    - 2) Importacion del archivo controller

        dentro de routes/api/api.php

        agregar la routa que involucre la clase que deseas modificar, en nuestro ejemplo sera create

        **Asi se escribe la ruta**
        Route::middleware('auth:sanctum')->post('/savings', [SavingsController::class, 'create']);//ruta para crear un saving auth:sanctum se tiene que usar cuando se hace mmodificaciones con authenticacion

