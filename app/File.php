<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class File extends Model {

	protected $fillable = ['name', 'description', 'file', 'size', 'folder_id', 'extension_id', 'user_id', 'created_at', 'updated_at'];

	public function folder() {

		return $this->belongsTo('\App\Folder');

	}
	public function extension() {

		return $this->belongsTo('\App\Extension');

	}

	public function user() {

		return $this->belongsTo('\App\User');

	}

	//ACCESOR .. FORMATEAR LEER DE LA TABLA EN $model->
	public function getSizeAttribute($value) {

		$precision = 2;
		if ($value > 0) {
			$value = (int) $value;
			$base = log($value) / log(1024);
			$suffixes = array(' bytes', ' KB', ' MB', ' GB', ' TB');

			return round(pow(1024, $base - floor($base)), $precision) . $suffixes[floor($base)];
		} else {
			return $size;
		}

		//$this->attributes['size'] = bcrypt($value);

	}

	//MUTADOR .. FORMATEAR ANTES DE GUARDAR
	public function setPasswordAttribute($value) {
	//	$this->attributes['password'] = bcrypt($value);
	}

}
