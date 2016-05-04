<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Input;

use App\Http\Requests;

use JWTAuth;

//use Tymon\JWTAuth\Exceptions\JWTException;


use App\User;


class AuthenticateController extends Controller
{
	public function __construct()
	{
		$this->middleware('jwt.auth', ['except' => ['login', 'singup']]);
	}

	public function index()
	{
		$users = User::all();
		return $users;
	}

	public function login(){

		$credentials = Input::only('email', 'password');

		try {
            // verify the credentials and create a token for the user
			if (! $token = JWTAuth::attempt($credentials)) {
				return response()->json(['error' => 'invalid_credentials'], 401);
			}
		} catch (JWTException $e) {
            // something went wrong
			return response()->json(['error' => 'could_not_create_token'], 500);
		}

        // if no errors are encountered we can return a JWT
		return response()->json(compact('token'));
	}


	public function singup(){
		$credentials = Input::only('email', 'password');
		$credentials['password'] = bcrypt($credentials['password']);

		try {
			$user = User::create($credentials);
			$token = JWTAuth::fromUser($user);

			return response()->json(compact('token'));

		} catch (Exception $e) {
			return response()->json(['error' => 'User already exists.'], 500);
		}

		
	}
}
