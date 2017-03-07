<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Extension extends Model {
	protected $fillable = ['name'];

	public function files() {

		return $this->hasMany('\App\File');

	}
}
