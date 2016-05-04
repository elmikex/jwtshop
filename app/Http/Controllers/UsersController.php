<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\User;

class UsersController extends Controller
{
	public function __construct()
	{
		$this->middleware('jwt.auth');
	}

	public function index(){
		return User::all();
	}

	
}
