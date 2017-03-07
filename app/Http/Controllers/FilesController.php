<?php

namespace App\Http\Controllers;
use App\File;										//cargar con el namespace el Modelo que se pretende utilizar ,obtener data o guardar.
use App\Extension;									//cargar con el namespace el Modelo que se pretende utilizar ,obtener data o guardar , puede ser algun otro para un fin especifico
use App\Folder;										//cargar con el namespace el Modelo que se pretende utilizar ,obtener data o guardar , puede ser algun otro para un fin especifico
use App\Log;										//cargar con el namespace el Modelo que se pretende utilizar ,obtener data o guardar , puede ser algun otro para un fin especifico
use App\User;										//cargar con el namespace el Modelo que se pretende utilizar ,obtener data o guardar , puede ser algun otro para un fin especifico
//use App\Http\Requests\FilesRequest; 				//carga del request personalizado con las reglas especificas.
use Illuminate\Http\Request;						//Clase de laravel que permite obtener los request(data e info)  de un formulario.
use Illuminate\Http\Response;						//Clase de laravel que permite utilizar las respueestas de estado del servidor.
use Illuminate\Support\Facades\File as FileFunc; 	//Clase de laravel que permite gestionar como objeto archivos , alias por conflicto con Model
use Illuminate\Support\Facades\Storage;				//Clase de laravel que permite el uso de almacenamiento y sus funcionalidades
use Laracasts\Flash\Flash;							//Cargar para poder usar el Plugin Flash previamente instalado con composer.
use Auth;											//Cargar Clase principal Auth para poder acceder a los datos del middwalre

class FilesController extends Controller {

/**
* { Constructur para utilizar y definir variables o funciones en todo el controlladopr }
*/
public function __construct()
{
	//$this->middleware('auth');	//condicionar el controllador al middwalere , auth para solo permitir si se esta logueado
	$this->module="Files";	//definir de forma globar la varible que contiene el nombre del modulo.
}



	/**
	* { methodo resource por default para mostrar al acceder al controlador.}
	*
	* @return     <object>  ( vista y datos)
	*/
	public function index() {

		$files = File::orderBy('id', 'DESC')->paginate(5);	//asignar a objeto 'extensions' el result de la consulta paginada de File.
		return view('admin.files.index')->with('files', $files);	//view para renderizar nombre de vista y with para pasar variable a vista.

	}


	/**
		* { funcion para obtetener el archivo guardado en disco  }
		*
		* @param      <int>  $file_id  id del file
		*
		* @return     <funcion>  ( funcion que descar el archivo indicado )
	*/
	public function get($file_id) {

		$file = File::where('id', '=', $file_id)->firstOrFail();	//Objeto igualado al resultado de el primero/firstorfail resultado del registro con id =?
		$file_url = Storage::disk('local')->url($file->file);    //Objeto igualado a la ruta(url) del nombre del archivo buscado, utilizando la opcion local de Storage

		//$file_storage = Storage::disk('local')->get($file->file); 						//crear objeto del archivo en storage local --response 200
		//return (new Response($file_storage, 200))->header('Content-Type', $file->mime); 	//retornart el objeto utilizando response para poder ver en linea
		
		if(!Auth::guest()){
		self::RegisterLog('Downloaded ' , $file->file ,$this->module ,Auth::user()->id);	//disparar methodo con parametros para guardar log.

		}
		return response()->download(public_path($file_url));	//descarga directa usando response, especioficamente download url de la ruta real del archivo
	}



	/**
	 * { methodo comun para solo mostrar la vista(formulario) de creacion. }
	 *
	 * @return     <object>  ( vista y/o datos)
	 */
	public function create() {

		$folders = Folder::pluck('name', 'id');  		//obtener en forma de array los campos especificados para poder usar en los combobox al iterar
		$extensions = Extension::pluck('name', 'id');   //obtener en forma de array los campos especificados para poder usar en los combobox al iterar
		$users = User::pluck('name', 'id');   			//obtener en forma de array los campos especificados para poder usar en los combobox al iterar

		$selects = array(
		'folders' => $folders,
		'extensions' => $extensions,
		'users' => $users,
		); 												//crear un array de los arrays individuales para mandar todo junto a la vista

		return view('admin.files.create')->with('data', $selects);	//retornar la vista con los datos anteriores

	}





	/**
	 * { methodo comun para guardar en BD request de Formulario (POST)  }
	 *
	 * @param      \Illuminate\Http\Request  $request  The request.
	 *
	 * @return     <function>                    ( redireccion a otra ruta o vista ).
	 */	
	public function store(Request $request) {

		$file_item = $request->file('filefield');						//usar file() de request para obtener los inputs del tipo file y sus informacion
		$extension = $file_item->getClientOriginalExtension();			//getClientOriginalExtension() retorna la extension original del File subido
		Storage::disk('local')->put($file_item->getClientOriginalName(), FileFunc::get($file_item));	//put sube el file con Storage en el lugar especificado de disk con el nombr y el fila en forma de objeto (FileFunc).
		//$files = Storage::files('/test');								//el methodo statico ::files obtiene en forma de array los archivos en x carpeta.
		$file = new File($request->all()); 								//todos los valores del input //instancia nueva de File con request (inputs del form)
		$file->file = $file_item->getClientOriginalName();				//getClientOriginalName() retorna el nombre original del File subido
		$file->size = $file_item->getSize();							//getSize() retorna el peso en bytes del File subido
		$file->mime = $file_item->getClientMimeType();					//getClientMimeType() retorna el mime-type original del File subido
		$file->save();													//se dispara el metodo save que guarda todo el objeto en la BD
		Flash::success('The File ' . $file->name . ' was created successfully');	//cargar un mensaje personalizado en la vista al redireccionar
		self::RegisterLog('Saved ' ,$file_item->getClientOriginalName() ,$this->module ,Auth::user()->id);	//disparar methodo con parametros para guardar log.

		return redirect()->route('files.index'); 						//redireccionar a la ruta especificada.
	}




	/**
	 * Methodo para eliminar de la BD algun registro en base a su id.
	 *
	 * @param      <int>  $id     id del item/registro a eliminar, pasado desde la ruta.
	 *
	 * @return     <function>		( redireccion a otra ruta o vista ).
	 */
	public function destroy($id) {

		$busqueda = File::where('id', '=', $id)->firstOrFail();	// resultado de el primero/firstorfail resultado del registro con id =?
		Storage::delete($busqueda->file);						//delete Methodo Statico de Storage que elimina un archivo con su nombre

		$file = File::find($id);								//Objeto con el resultado de la busqueda(find) de un registro con un id en especifico.
		$file->delete();										//borrar registro sobre el objeto previamente encontrado.
		Flash::error("El archivo ah sido borrada con exito");	//cargar un mensaje personalizado en la vista al redireccionar.
		self::RegisterLog('Deleted ' , $file->name ,$this->module ,Auth::user()->id);	//disparar methodo con parametros para guardar log.

		return redirect()->route('files.index');				//redireccionar a la ruta especificada.
	}



	/**
	 * { methodo comun para solo mostrar la vista(formulario) de Edicion. }
	 * @param      <type>  $id     id del registro a editar
	 * 
	 * @return     <object>  ( vista con los datos encontrados del id)
	 */
	public function edit($id) {

		$file = File::find($id);	//Objeto con el resultado de la busqueda(find) de un registro con un id en especifico.
		return view('admin.files.edit')->with('file', $file);	//pasar a la vista los dato de la extension para mostrar en el formulario al editar
	
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

		$file = File::find($id);					//Objeto con el resultado de la busqueda(find) de un registro con un id en especifico.
		$file->fill($request->all());				//'llenar' al objeto especifico los datos del formulario con los datos por actualizar
		$file->save();								//guardar ese nuevo objeto en la BD (remplazo/actualizacion)
		Flash::warning("El archivo ah sido Editado ");	//cargar un mensaje personalizado en la vista al redireccionar.
		self::RegisterLog('Updated ' , $file->name,$this->module  ,Auth::user()->id);	//disparar methodo con parametros para guardar log

		return redirect()->route('files.index');	//redireccionar

	}



	/**
		* { Methodo que registrar el Log de cada evento }
		*
		* @param      string   $action   Accion del evento o predicado de la accion a registrar en el log
		* @param      string   $value    valor adicional o de referencia para concatenar con la accion
		* @param      integer  $user_id  id del usuario que esta disparando la accion que se registra en el log
	*/
	public function RegisterLog($action , $value="" , $module="" , $user_id=00){

		//$log = new Log(array("action" => "SAVE " . $extension->name, "module" => "Files", "user_id" => 1));	//objeto con instancia del Modelo Log para 
		$data=array("action" => $action.' ' . $value,
		"module" => $module,
		"user_id" => $user_id);	//array con las variables por evento y con constantes propias del modulo.

		$log = new Log($data);	//objeto con instancia del Modelo Log para guardar los datos del log
		$log->save();	//disparar el methodo save que guarda en BD los datos del objeto creado.

}
}
