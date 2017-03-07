<?php

namespace App\Http\Controllers;
use App\Http\Requests\UsersRequest;		//Clase de laravel que permite obtener los request(data e info)  de un formulario.
use App\Log;							//cargar con el namespace el Modelo que se pretende utilizar ,obtener data o guardar , puede ser algun otro para un fin especifico
use App\User;							//cargar con el namespace el Modelo que se pretende utilizar ,obtener data o guardar.
use Illuminate\Http\Request;			//Clase de laravel que permite obtener los request(data e info)  de un formulario.
use Laracasts\Flash\Flash;				//Cargar para poder usar el Plugin Flash previamente instalado con composer.
use Auth;								//Cargar Clase principal Auth para poder acceder a los datos del middwalre

 
class UsersController extends Controller {


	/**
	 * { Constructur para utilizar y definir variables o funciones en todo el controlladopr }
	 */
	public function __construct()
	{
	    $this->middleware('auth');	//condicionar el controllador al middwalere , auth para solo permitir si se esta logueado
	    $this->module="Users";	//definir de forma globar la varible que contiene el nombre del modulo.
	}


	/**
	 * { methodo resource por default para mostrar al acceder al controlador.}
	 *
	 * @return     <object>  ( vista y datos)
	 */
	public function index() {

		$users = User::orderBy('id', 'DESC')->paginate(5);	//asignar a objeto 'extensions' el result de la consulta paginada de User.
		return view('admin.users.index')->with('users', $users);	//view para renderizar nombre de vista y with para pasar variable a vista.

	}


	/**
	 * { methodo comun para solo mostrar la vista(formulario) de creacion. }
	 *
	 * @return     <object>  ( vista y/o datos)
	 */
	public function create() {

		return view('admin.users.create');	//al crear un 'as' en route es posible acceder a una ruta con '.' en ves de '/'.

	}


	/**
	 * { methodo comun para guardar en BD request de Formulario (POST)  }
	 *
	 * @param      \Illuminate\Http\Request  $request  The request.
	 *
	 * @return     <function>                    ( redireccion a otra ruta o vista ).
	 */
	public function store(UsersRequest $request) {

		$user = new User($request->all());	//Objeto con nueva instancia del Modelo a utilizar (User) pasandole los datos del request con ->all();
		$user->save();	//disparar el methodo save que guarda en BD los datos del objeto creado.
		Flash::success('The User <strong>' . $user->name . '</strong> was created successfully');	//cargar un mensaje personalizado en la vista al redireccionar
		self::RegisterLog('Saved ' , $user->name ,$this->module ,Auth::user()->id);	//disparar methodo con parametros para guardar log. 

		return redirect()->route('users.index');	//redireccionar a la ruta especificada.
	}



	/**
	 * Methodo para eliminar de la BD algun registro en base a su id.
	 *
	 * @param      <int>  $id     id del item/registro a eliminar, pasado desde la ruta.
	 *
	 * @return     <function>		( redireccion a otra ruta o vista ).
	 */
	public function destroy($id) {

		$user = User::find($id);	//Objeto con el resultado de la busqueda(find) de un registro con un id en especifico.
		$user->delete();	//borrar registro sobre el objeto previamente encontrado.
		Flash::warning('Deleted User <strong>' . $user->name . '</strong>  ');	//cargar un mensaje personalizado en la vista al redireccionar.
		self::RegisterLog('Deleted ' , $user->name ,$this->module ,Auth::user()->id);	//disparar methodo con parametros para guardar log.

		return redirect()->route('users.index');	//redireccionar a la ruta especificada.

	}


	
	/**
	 * { methodo comun para solo mostrar la vista(formulario) de Edicion. }
	 * @param      <type>  $id     id del registro a editar
	 * 
	 * @return     <object>  ( vista con los datos encontrados del id)
	 */	
	public function edit($id) {

		$user = User::find($id);	//Objeto con el resultado de la busqueda(find) de un registro con un id en especifico.
		return view('admin.users.edit')->with('user', $user);	//pasar a la vista los dato de la extension para mostrar en el formulario al editar

	}



	/**
	 * { methodo comun para Editar en BD request de Formulario (PUT)  }
	 *
	 * @param      \Illuminate\Http\Request  $request  The request
	 * 
	 * @param      <int>  $id     id del item/registro a eliminar, pasado desde la ruta.
	 *
	 * @return     <function>                    ( redireccion a otra ruta o vista ).
	 */
	public function update(Request $request, $id) {

		$user = User::find($id);	//Objeto con el resultado de la busqueda(find) de un registro con un id en especifico.
		$user->fill($request->all());	//'llenar' al objeto especifico los datos del formulario con los datos por actualizar
		$user->save();	//guardar ese nuevo objeto en la BD (remplazo/actualizacion)
		Flash::info('The User <strong>' . $user->name . '</strong> was updated ');	//cargar un mensaje personalizado en la vista al redireccionar.
		self::RegisterLog('updated ' , $user->name,$this->module  ,Auth::user()->id);	//disparar methodo con parametros para guardar log	 

		return redirect()->route('users.index');	//redireccionar

	}



	/**
		* { Methodo que registrar el Log de cada evento }
		*
		* @param      string   $action   Accion del evento o predicado de la accion a registrar en el log
		* @param      string   $value    valor adicional o de referencia para concatenar con la accion
		* @param      integer  $user_id  id del usuario que esta disparando la accion que se registra en el log
	*/
	public function RegisterLog($action , $value="" , $module="" , $user_id=00){

		//$log = new Log(array("action" => "SAVE " . $extension->name, "module" => "Extensions", "user_id" => 1));	//objeto con instancia del Modelo Log para 
		$data=array("action" => $action.' ' . $value,
		"module" => $module,
		"user_id" => $user_id);	//array con las variables por evento y con constantes propias del modulo.

		$log = new Log($data);	//objeto con instancia del Modelo Log para guardar los datos del log
		$log->save();	//disparar el methodo save que guarda en BD los datos del objeto creado.

}
	

}
