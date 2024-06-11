# Fetch infomation from DB

## paso a seguir

1) Crear la funcion en el controller deseado, en este ejemplo
   iremos al Savings Controller y crearemos la funcion para hacer un
   fetch de los savings

 ```php
    public function fetchUserSavings(Request $request)
    {
        $user = $request->user(); // obtiene el usuario actual autenticado a traves del token enviado por el front
        $savings = $user->savings; // obtiene el ahorro del usuario autentificado
        return response()->json(['savings' => $savings], 200); // responde con los savings
    }
 ```

2) Crear una nueva ruta en laravel en api.php
    de clase get para poder obtener informacion

   Route::middleware('auth:sanctum')->get('/savings', [SavingsController::class, 'fetchUserSavings']); // ruta para obtener los savings de los usuarios

3) request in the front
```js
 const fetchSavings = async () => {
      try {
        const response = await axios.get("http://127.0.0.1:8000/api/savings", {
          headers: {
            Authorization: `Bearer ${authToken.value}`, // incluir el token en el header para recuperar los savings de este header
          },
        });

        savingsList.value = response.data.savings;
        console.log("Recuperando savings:", response.data.savings);
      } catch (error) {
        console.error("Error fetching savings:", error);
      }
    };

    // Llama a fetchSavings cuando el componente se monta
    onMounted(fetchSavings);
```