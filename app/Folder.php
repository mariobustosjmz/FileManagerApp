<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model {

	protected $fillable = ['name', 'path', 'updated_at'];

	public function files() {

		return $this->hasMany('\App\File');

	}

}
