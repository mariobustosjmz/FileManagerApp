
#LARAVEL - APP FILE MANAGER




##INSTALACION LARAVEL

> Usando composer:

```
composer create-project laravel/laravel --prefer-dist Proyecto
```

> Una vez instalado laravel es recomendable situarse en la raíz del proyecto y ejecutar:

```
composer update
php artisan key:generate
php artisan app:name NombreApp
```

##Composer JSON

- "**name**": En esta sección se describe el nombre del usuario propietario del proyecto seguido del nombre del repositorio que aloja el proyecto separados por una barra(/).

- "**description**": Sirve para facilitar una breve descripción del paquete. Debemos ser muy claros y breves si deseamos colocar una descripción de nuestro paquete.

- "**keywords**": Estas palabras claves son una matriz de cadenas usadas para representar tu paquete. Son similares a etiquetas en una plataforma de blogs y, esencialmente, sirven al mismo propósito. Las etiquetas te ofrecen metadatos de búsqueda para cuando tu paquete sea listado en un repositorio.

- "**homepage**": La configuración de la página es útil para paquetes que van a ser de código libre. Puedes usar esta página para el proyecto o quizá para la URL del repositorio. Lo que creas que es más informativo.

- "**license**": Si tu paquete está pensado para ser redistribuido, querrás ofrecer una licencia con él. Sin una licencia muchos programadores no podrán usar el paquete por restricciones legales. Escoge una licencia que se ajuste a tus requisitos, pero que no sea muy restrictiva para aquellos que esperan usar tu código. El proyecto de Laravel usa la licencia MIT que ofrece gran libertad.

- "**authors**": ofrece información sobre los autores del paquete, y puede ser útil para aquellos usuarios que quieran contactar con el autor o autores. Ten en cuenta que la sección de autores permite una matriz de autores para paquetes colaborativos.

##Agregar nuevo paquete

```
"require-dev": {
"nombre_packete/nombre_packete_subv": "0.9.*", //asterisco para cualquiera superior o cambio
},


```
>Revisar en documentacion si es necesario agregarse en **Providers** y/o **Aliases**

```
FlashServiceProvider
'Form' => Collective\Html\FormFacade::class,
'Html' => Collective\Html\HtmlFacade::class,
'Html' => Laracasts\Flash\FLash::class,
```

### Agregar Paquete HTML Facade y Mensajes Flash
>Modificar composer.json y agregar en la seccion :


```
"require": {
"laravelcollective/html" :"^5.3",
"laracasts/flash": "^2.0"
},

__Leer Documentacion

```


## Conexión con bases de datos
>Laravel tiene soporte para los motores de bases de datos más populares como:
- MySQL
- Postgresql
- SQLite3
- SQL Server


>Dentro del archivo `database.php` en el directorio `config` configuramos el driver de la conexión, por defecto vendrá con mysql, si queremos cambiarlo por otro motor de base de datos tendremos que cambiar el valor mysql por sqlite, pgsql, sqlsrv...

```
'default' => env('DB_CONNECTION', 'mysql')
```

>Tendremos que configurar el archivo `.env` ubicado en la raíz del proyecto.

```
DB_HOST=localhost
DB_DATABASE=curso
DB_USERNAME=root
DB_PASSWORD=12345
```
>Una vez que tengamos todo configurado, nos dirigimos a la terminal y ejecutamos el comando `php artisan migrate` para crear las migraciones, si todo ha salido bien tendremos que ver las tablas:

```
migrations
password_resets
users
```
>Es por convencion de Laravel usar el nombre de las Tablas en Plural para que pueda utilizarlas al 100 en los Modelos.

##ESTRUCTURA DE LARAVEL
>https://laravel.com/docs/5.3/structure


##MIGRACIONES

>Cuando creamos nuestras bases de datos solemos crear diagramas que nos facilitan la abstracción de como se va a almacenar nuestra información, pero la forma de llevarlo a la realidad en algun gestor de bases de datos, como por ejemplo: **MySQL, SQLite, PostgreSQL, SQL Server**, etc., lo más comun es meternos al lenguaje de script encargado de implementar nuestra idea de la BD y ejecutar dicho script, o incluso ocupar programas más avanzados que nos sirven como interfaz para crearlas de una forma más gráfica y sin la necesidad de profundizar demasiado en el lenguaje, como Workbench o Navicat.

>En Laravel se lleva a otro contexto esta situación, puesto que visto de la forma tradicional si se requieren cambios en la base de datos tenemos que meternos ya sea a otro programa para cambiar el diagrama de la base o a un archivo SQL con una sintaxis usualmente complicada o difícil de leer y ejecutar los cambios para reflejarlos en el proyecto, sin embargo, con esto no contamos con un control de los cambios (control de versiones) sobre la base de datos, si necesitamos consultar un cambio anterior o de repente la solución previa o inicial era la que se necesita al momento debemos re-escribir todo otra vez, cosa que con la migraciones se soluciona instantaneamente.+

>Las migraciones son archivos que se encuentran el la ruta `database/migrations/` de nuestro proyecto Laravel, por defecto en la instalación de Laravel 5 se encuentran dos migraciones ya creadas, `create_users_table` y `create_password_resets_table`.

```
php artisan make:migration nombre_migracion
o
php artisan make:migration N --create=N_table //para pasar el nombre de la tabla de una vez

$table->increments('id');  //int, primario ,autoincrementable
$table->string('name');    //varchar
$table->string('email')->unique();
$table->string('password', 60);
$table->enum('type', ['member', 'admin'])->default('member'); //opciones especificas
$table->rememberToken();
$table->timestamps();  //create & update_at

php artisan migrate //ejecutar las migraciones

```

>Documentacion de los tipos de campos y opciones de laravel
https://laravel.com/docs/5.0/schema#adding-columns


```
php artisan migrate
```
>Con esto si es la primera vez que se ejecuta este comando se creará en nuestra base de datos la tabla migrations que es la encargada de llevar el control de que migraciones que ya han sido ejecutadas, con el fin de no correr el mismo archivo más de una vez si el comando se usa nuevamente.

```
php artisan migrate:rollback  //deshacer la última migración ejecutada y registrar.

php artisan migrate:reset // deshacer todas las migraciones de la base de datos.

php artisan migrate:refresh  //reset and migrate
```

>Para agregar mas campos a una tabla, se puede editar la migracion y hacer un reset, o crear una migracion especifica
que solo agrege los campos nuevos, esto para tener un Control de Versiones mejor de las tablas
solo se necesita cambiar 'create' por 'table' en Schema

```
Schema::table('nombre_tabla',function(Blueprint... ))
```


###Crear  migraciones del Proyecto

```
php artisan make:migration files --create=files
php artisan make:migration folders --create=folders
php artisan make:migration extensions --create=extensions
php artisan make:migration logs --create=logs

--agregar campos a consideracion

//foranea		
$table->integer('tabla_id')->unsigned();//primario
//relaciones
$table->foreign('tabla_id')->references('id')->on('tablas')->onDelete('cascade');
$table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


//Tablas pivotes
tabla1_tabla2
Schema::create('file_folder', function (Blueprint $table) {
$table->increments('id');
$table->integer('file_id')->unsigned();
$table->integer('folder_id')->unsigned();
$table->timestamps();

$table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
$table->foreign('folder_id')->references('id')->on('folders')->onDelete('cascade');;

});
}


```

##Seeders

>Los Seeders por otra parte son archivos que nos van a permitir poblar nuestra base de datos para no tener que perder el tiempo escribiendo de forma manual todos los datos, un ejemplo, imagina llenar 15 tablas con 100 registros cada una y piensa en que entre cada tabla deben existir registros que se relacionan entre sí, eso suena de verdad horrible y tedioso, por lo cual Laravel nos salva con estos archivos Seeders.+

>Un Seeder se ubica en la carpeta `database/seeds/` de nuestro proyecto de Laravel y para poder crear un nuevo Seeder se usa el comando:

```
php artisan make:seeder TestsSeeder

//Componente Faker -> composer.json

//USAR en Seeder //App/database/seeds/UsersTableSeeder.php
use Faker\Factory as Faker 

run(){

$faker = Faker::create();
for ($i=0; $i < 20; $i++) {
\DB::table('nombre_tabla')->insert(array(
'nombre' => $faker->firstNameFemale,
'direccion' => $faker->address,

'opciones'  => $faker->randomElement(['opcion1','opcion2','opcion3']),
'created_at' => date('Y-m-d H:m:s'),
'updated_at' => date('Y-m-d H:m:s')
));
}

}

```

>Documentacion https://github.com/fzaninotto/Faker

>Abrir  archivo llamado `DatabaseSeeder.php`, en este archivo se mandan a llamar todos los seeders en el orden que los necesitemos, en este archivo se agregará la linea:

```
$this->call('TestsSeeder');

//EJECUTAR SEEDER

php artisan db:seed

php artisan migrate --seed //Combinacion

php artisan migrate:refresh --seed //combinar todo


});

```


### Crear nuestros propios Seeders de prueba

`php artisan make:seeder UsersTableSeeder`

```
	public function run() {

		$faker = Faker::create();

		for ($i = 0; $i < 20; $i++) {

			\DB::table('users')->insert(array(
					'name'       => $faker->firstName.' '.$faker->lastName,
					'email'      => $faker->companyEmail,
					'password'   => bcrypt($faker->password),
					'rol_id'     => $faker->randomElement(['1', '2', '3']),
					'created_at' => date('Y-m-d H:m:s'),
					'updated_at' => date('Y-m-d H:m:s')
				));

		}
	}
	...
```




## Model Factories

>Los model Factories en realidad también trabajan con el componente Faker, esto lo podemos confirmar si miramos nuestro composer.json, sin embargo, nos ofrecen una manera más elegante y ordenada de trabajar.

```
$factory->define(App\User::class, function ($faker) {
return [
'name' => $faker->name,
'email' => $faker->email,
'password' => str_random(10),
'remember_token' => str_random(10),
];
});

// Creamos un model factory para poblar usuarios de tipo administrador
$factory->defineAs(App\User::class, 'administrador', function ($faker) {
return [
'name' => $faker->name,
'email' => $faker->email,
'password' => str_random(10),
'type' => 'administrador',
'remember_token' => str_random(10),
];
});


```

>Una vez creados los Model Factories, debemos ir al archivo `database/seeds/DatabaseSeeder.php` y ejecutar el poblado dentro del método run como en el siguiente ejemplo:


```

Model::unguard();
factory('Curso\User', 50)->create();
factory('Curso\User','administrador',1)->create();        
// $this->call('UserTableSeeder');
```

###Crear Model Factories propios de la App

`App/database/factories/ModelFactory.php`

```
<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

...

```



## Modelos y  Eloquent

### Eloquent/ORM
>En Laravel podemos hacer uso de un ORM llamado Eloquent, un ORM es un Mapeo Objeto-Relacional por sus siglas en ingles (Object-Relational mapping), que es una forma de mapear los datos que se encuentran en la base de datos almacenados en un lenguaje de script SQL a objetos de PHP y viceversa, esto surge con la idea de tener un codigo portable con el que no tengamos la necesidad de usar lenguaje SQL dentro de nuetras clases de PHP.

>Los modelos usan convenciones para que a Laravel se le facilite el trabajo y nos ahorre tanto líneas de código como tiempo para relacionar más modelos, las cuales son:

- El nombre de los modelos se escribe en singular, en contraste con las tablas de la BD que se escriben en plural.
- Usan notacion UpperCamelCase para sus nombres.



> Estas convenciones nos ayudan a detectar automaticamente las tablas, por ejemplo: el modelo **User** se encuentra en **singular** y con notacion **UpperCamelCase** y para Laravel poder definir que tabla es la que esta ligada a este modelo le es suficiente con realizar la conversion a notacion **underscore** y **plural**, dando como resultado la tabla: **users**.

```

user_profiles  -> UserProfile //Singular y UpperCamelCase

php artisan make:model Test
=
protected $table = 'tests';  //detectado por default

php artisan make:model Situacion
=
protected $table = 'situacions'; // X //redefinir el nombre de tabla

$test = Test::where('opciones','opcion1')->first();
$test = Test::where('opciones','opcion1')->get();
```


###Scopes ..Filtros 
>Eloquent nos provee de una herramienta llamada **scopes** que lo que realizan son consultas en especifico encapsulandolas dentro de funciones en el modelo,

```

public function scopeOpcion1($query){
return $query->where('opciones','opcion1');
}


$tests = Test::opcion1()->get();

```

>Para insertar la sintaxis seria la siguiente:

```
$test = new Test;

$test->nombre = 'Test Bame ';
$test->opcion  = 'opcion1';

$test->save();
```

>Para actualizar seria la siguiente:

```
$test = Test::find(51);

$test->opcion = 'opcion2';

$test->save();
```

>Para eliminar seria la siguiente:

```
$test = Test::find(51);

$test->delete();
```

> o bien podriamos destruir el registro directamente con el modelo si tenemos su ID:

`Test::destroy(51);`



###Crear los Modelos de la Aplicacion

```
php artisan make:model File
php artisan make:model Folder
php artisan make:model Extension
php artisan make:model Log

```







## Tipos de rutas por encabezado Http

>Las rutas están siempre declaradas usando la clase Route . Eso es lo que tenemos al principio, antes de :: . La parte get es el método que usamos para ‘capturar’ las peticiones que son realizadas usando el verbo ‘GET’ de HTTP hacia una URL concreta.

```

// ruta de tipo GET que devuelve una vista
Route::get('/', function () {
return view('welcome');
});

Route::get('home', 'HomeController@index');


Route::get('/libros/{genero}',function($genero){

switch($genero){

case: 'terror':

return 'Libros del Genero de Terror';
break;

case:'drama'
return...
}
});


Route::get('/pagina/{numero?}',function($numero=1){
...

})->where('numero','{0-9}m');

}


```

###  Crear las Rutas de nuestra Applicacion

```

Route::group(['prefix' => 'admin'], function () {

Route::resource('users', 'UsersController');

Route::get('users/{id}/destroy', [
'uses' => 'UsersController@destroy',
'as' => 'admin.users.destroy',
]);

//edit put
//insert create
//get ,find,all

Route::resource('folders', 'FoldersController');
Route::get('folders/{id}/destroy', [
'uses' => 'FoldersController@destroy',
'as' => 'admin.folders.destroy',
]);
});

```





#Vistas y Blade

>Plantillas con terminacion .blade que nos ayudan a maximizar las capacidades y mnimizar las lineas de codigo, centrandonos en el uso y estructura de la vista como tal

```

Route::get('test', function(){
$test = Test::opciones('opcion1')->first();
return view('vista')->with('variable', $test->nombre);
});


<h2>{{ $variable }}</h2>




@if( $opciones->count() > 10 )
<h1>Existen mas de 10 opciones</h1>
@endif
<p>Iteramos</p>
<h1>Lista de opciones</h1>
@foreach($opciones as $opcion)
<h2>{{ $opcion->nombre }}</h2>
@endforeach



```
### Templates
>Plantillas y secciones para ahorrar codigo repetitivo

```
@extends('template') //'' nombre del archivo que servira como template
```


>Un template es una vista como las demás, simplemente que dentro de ella se usan otras sentencias que nos va a permitir definir areas del archivo que se van a poder sustituir mas adelante dentro de otra vista si es que lo deseamos. Se necesita:

```
@yield('nombre_seccion') //seccion abierta o contenedora

@section('nombre_seccion') //apartir de donde se incrustara al yield 
```
>....

```
@extends('template')

@section('content')
<h1>Lista de opciones</h1><br>
@if( $opciones->count() > 10 )
<h2>Hay muchos Tests</h2><br>
@endif
@foreach($opciones as $opcion)
<h4>{{ $opcion->nombre }}</h4>
@endforeach
@stop
```



### Partials

```
include('nombre.partial')
```


https://laravel.com/docs/5.0/templates


###Crear las vistas de nuestra aplicacion , template"




#Controladores


>Los Controladores puede agrupar las peticiones HTTP relacionada con la manipulación lógica en una clase. Los Controladores normalmente se almacenan en el directorio de aplicación `app/Http/Controllers/`.Un controller usualmente trabaja con las peticiones:+


- _GET_: index, create, show, edit.
- _POST_: store.
- _PUT_: update.
- _DELETE_: destroy.
- _PATCH_: update.

>Agrupar peticiones en una clase que se liga desde las rutas

`Route::resource('pasteles', 'PastelesController'); (index, create, show, edit, store, update, destroy)`


- **index**: Es el método inicial de las rutas resource, usualmente lo usamos para mostrar una vista como página principal que puede contener un catalogo o resumen de la información del modelo al cual pertenece o bien no mostrar información y solo tener la función de página de inicio.

- **create**: Este método lo podemos usar para direccionar el sistema a la vista donde se van a recolectar los datos(probablemente con un formulario) para después almacenarlos en un registro nuevo, usualmente redirige al index.

- **show**: Aqui podemos hacer unna consulta de un elemento de la base de datos o de todos los elementos o registros por medio del modelo para realizar una descripcion.

- **edit**: Este método es similar al de create porque lo podemos usar para mostrar una vista que recolecta los datos pero a diferencia de create es con el fin de actualizar un registro.

- **store**: Aqui es donde se actualiza un registro en especifico que proviene del método create y normalmente redirige al index.

- **update**: Al igual que el store, solo que en vez de provenir de create proviene de edit y en vez de crear un nuevo registro, busca un existente y lo modifica, tambien suele redirigir al index.

- **destroy**: En este método usualmente se destruye o elimina un registro y la petición puede provenir de donde sea siempre y cuando sea llamado con el método DELETE, después puede redirigir al index o a otro sitio dependiendo si logro eliminar o no.


`php artisan make:controller NombreControllador  //-r resource , para tener todos los metodos ` 


>Ver el nombre de las rutas, de que tipo son, si es que reciben parametros y como se llaman,esta información es muy util para poder asociar los métodos del controlador con las rutas y tambien como es que las vamos a usar en el navegador.

`php artisan route:list`

>Doc:
https://laravel.com/docs/5.1/controllers |  
https://laravel.com/docs/5.1/routing



###Validación del lado del servidor (Request).

>Laravel permite validar los datos enviados por un formulario de forma muy sencilla ocupando un Mecanismo llamados "Requests" `app/Http/Request/`


```
php artisan make:request UsersRequest

...
public function authorize()
{
	return true;
}

```


>Usar el Request creado en el Controllador

```
use App\Http\Requests\UsersRequest;
```

>Modelo , decirle al modelo que puede usarlos 

```
protected $fillable = ['name','email'];
```


>Controllador:

```
public function store(CrearUsuario $request)
{
	$usuario = Usuario::create($request->all());
	return redirect()->route('usuarios.index');
}

```


https://laravel.com/docs/5.1/validation#rule-integer

###MIDDLEWARE

>Middleware para la autenticacion o logueo de los usuarios en nuestras rutas. Por defecto en nuestro proyecto de Laravel debemos de contar con un middleware llamado auth, este middleware de lo que se encarga es de ver que el usuario se encuentre con una sesion activa, recuerden que en Laravel ya tenemos por defecto el manejo de sesiones junto con las tablas de la base de datos. Para decirle a nuestro proyecto que las rutas de nuestros controladores  van a estar protegidas por el middleware auth usamos el método middleware('name'); 


```

public function __construct(){
$this->middleware('auth');

}
```

>Modificar Usuario , Roles:

```
$table->enum('type', ['admin','user']);

 /app/User.php
protected $fillable = ['name', 'email', 'password', 'type'];

 

app/Http/Controllers/Auth/RegisterController.php

return User::create([
'name' => $data['name'],
'email' => $data['email'],
'password' => bcrypt($data['password']),
'type' => $data['type'],
]);
}


resources/views/auth/register.blade.php

<div class="form-group">
	<label for="type"> Type</label>
	<select name="type" class="form-control">
		<option value="" disabled selected>Elige una opcion...</option>
		<option value="admin">Administrador</option>
		<option value="user">Usuario normal</option>
	</select>
</div>


//Crear Midd

php artisan make:middleware IsAdmin


<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;

class IsAdmin {
	protected $auth;

	public function __construct(Guard $auth) {
		$this->auth = $auth;
	}
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		if ($this->auth->user()->type != 'admin') {
			$this->auth->logout();
			if ($request->ajax()) {
				return response('Unauthorized.', 401);
			} else {
				return redirect()->to('auth/login');
			}
		}

		return $next($request);
	}
}

//Usaremos la función ->to(); porque si nos quedamos con la función guest() eso guarda la ruta de destino a la que queremos llegar y nunca vamos a poder iniciar sesion con usuarios normales.

//Registrar en Kernel.php
Usaremos la función ->to(); porque si nos quedamos con la función guest() eso guarda la ruta de destino a la que queremos llegar y nunca vamos a poder iniciar sesion con usuarios normales.




HomeController.php
	public function __construct() {
		$this->middleware('auth');
		$this->middleware('is_admin');

	}

```

#Extra  , Next Steps FileManagerApp

- Agregar grupo de rutas admin
- agregar todas las rutas pertenecientes
- asociar cada controllador
- instalar ColectiveHtml para usarlo en la vista https://laravelcollective.com/docs/5.3/html
	
```
"laravelcollective/html" :"^5.3",

composer require "laravelcollective/html":"^5.3.0"

  'providers' => [
    // ...
    Collective\Html\HtmlServiceProvider::class,
    // ...
  ],

  'aliases' => [
    // ...
      'Form' => Collective\Html\FormFacade::class,
      'Html' => Collective\Html\HtmlFacade::class,
    // ...
  ],
```


- agregar assets  `{{ asset('css/bootstrap.css') }} `

- crear las vistas
- implementar flash  use Laracasts\Flash\Flash;
- crear request personalizado use App\Http\Requests\FolderssRequest;
-Relacion entre modelos

```	
public function folder() { //diff

		return $this->belongsTo('\App\Folder');

	}
	public function files() { //diff

		return $this->hasMany('\App\File');

	}

add to protected $fillable = [ ... ]
```

- completar controlladores
- obtener valores de relaciones
- subir archicos
- inyectar Logs





##