# Creacion de migracion 

las migraciones son utilizadasen laravel para poder crear las bases de datos,
estas luego se actulizaran a la base de datos que tenemos conectada con laravel
en el caso de este proyecto estoy utilizando Posgresql

los datos de la base de datos y sus conecciones estan establecidas
dentro del archivo .env dentro de la carpeta de backend


## PASOS A SEGUIR 

- 1) Creacion de la migracion
    Para crear la migracion vamos a usar un comando en la consola
    
    **este es el comando**
    php artisan make:migration nombre-tabla

- 2) Creacion de la estructura de la tabla
    Aqui dentro de el archivo se podra ver que se crean unos imports
    y dos metodos:
    UP-> aqui es donde se especifican las acciones para crear la tabla, agregar columans etc

    DOWN -> es el metodo que describe las operaciones para deshacer los cambios realizados 
    en el metodo UP, se utiliza para revertir la migracion, permitiendo regrersar al estado anterior antes de aplicar la migracion (eliminar tablas, revertir alteraciones de columnas, etc)

    aqui un ejemplo de la migracion de la tabla CreateSavings
    
    ```php
        use Illuminate\Database\Migrations\Migration;
        use Illuminate\Database\Schema\Blueprint;
        use Illuminate\Support\Facades\Schema;

        class CreateSavingsTable extends Migration
        {
            public function up()
            {
                Schema::create('savings', function (Blueprint $table) {
                    $table->id();
                    $table->unsignedBigInteger('user_id'); // Relacionado con el usuario
                    $table->string('name');
                    $table->decimal('amount', 10, 2); // Cantidad ahorrada
                    $table->decimal('goal', 10, 2); // Meta de ahorro
                    $table->date('deadline')->nullable(); // Fecha límite para ahorrar
                    $table->timestamps();

                    $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                    //esta linea lo que hace es anclear una clave extrangera en la creacion
                    // del saving, se crea el saving con respecto a la id del usuario
                    // de esta manera sabra que usuario creo el saving
                });
            }

            public function down()
            {
                Schema::dropIfExists('savings');
            }
        }
    ```
- 3) Ejecutar la migracion
    Este es el paso para que la migracion creada anteriormente se cree dentro de la base de datos
    en este caso deberia verse en postgresql

    **este es el comando**
    php artisan migrate

    Despues de esto tiene que aparecer dentro de la base de datos de posrgresql

# Definicion del modelo
- 4) Definicion del modelo y la relacion con el usuario
    Dentro del modelo savings como ejemplo puedo definir la relacion con el modelo user.
    Esto ayuda a acceder mas facil los ahorros de un usuario especifico.

    **IMPORTANTE**
    El modelo actua en laravel como representante de la base de datos (por eso siempre hay que crearlo)
    Ayuda a interactuar con la tabla, a traves de consultas, inserciones, actualiuzaciones y eliminaciones de registro.

    Tambien permite relaciones entre otras tablas

    **crear el archivo app/models/Savings.php**

    ```php
        namespace App\Models;
        use Illuminate\Database\Eloquent\Model;

        class Savings extends Model
        {
            protected $fillable = [
                'name',
                'amount',
                'goal',
                'deadline',
            ];

            public function user()
            {
                return $this->belongsTo(User::class);
            }
        }
    ```

Nota
si tu migration tiene un id foraneo, tinenes que agregar la relacion tambien 
en el model del foraneo asi

// este es el model de user donde le pasamos la funcion savings
mostrando asi la relacion de que un user puede tener many savings

```php
    public function savings()
{
    return $this->hasMany(Savings::class);
}
```


Ahora con esto quedo listo la base de datos para que puedas hacer migraciones
pero antes debes organizar los controladores de la tabla que acabaste de hacer


