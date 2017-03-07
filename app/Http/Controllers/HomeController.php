<?php

namespace App\Http\Controllers;
use Auth;
class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */

	protected $auth;


	public function __construct()
	{
	    $this->module="Home"; //definir de forma globar la varible que contiene el nombre del modulo.
	}


	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index() {
		return view('home');
	}
}
