<?php

namespace App\Http\Controllers\Admin;
use App\Log;								//cargar con el namespace el Modelo que se pretende utilizar ,obtener data o guardar , puede ser algun otro para un fin especifico
//use App\Http\Requests\LogsRequest;        //carga del request personalizado con las reglas especificas.
//use Illuminate\Http\Request;				//Clase de laravel que permite obtener los request(data e info)  de un formulario.
//use Laracasts\Flash\Flash;				//Cargar para poder usar el Plugin Flash previamente instalado con composer.
use Auth;									//Cargar Clase principal Auth para poder acceder a los datos del middwalre

class LogsController extends Controller {


	/**
	 * { Constructur para utilizar y definir variables o funciones en todo el controlladopr }
	 */
	public function __construct()
	{
	    $this->middleware('auth'); //condicionar el controllador al middwalere , auth para solo permitir si se esta logueado
	    $this->module="Logs"; //definir de forma globar la varible que contiene el nombre del modulo.
	}

	/**
	 * { methodo resource por default para mostrar al acceder al controlador.}
	 *
	 * @return     <object>  ( vista y datos)
	 */
	public function index() {

		$logs = Log::orderBy('id', 'DESC')->paginate(10);//asignar a objeto 'extensions' el result de la consulta paginada de Extension.
		return view('admin.logs.index')->with('logs', $logs);//view para renderizar nombre de vista y with para pasar variable a vista.

	}

}
