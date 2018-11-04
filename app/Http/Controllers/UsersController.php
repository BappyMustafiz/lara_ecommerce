<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use App\User;

class UsersController extends Controller
{
    /*function for register page*/
    public function login_register(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		//check user already exists
    		$usersCount = User::where('email',$data['email'])->count();
    		if($usersCount > 0){
    			return redirect()->back()->with('flash_message_error','Email already exists');
    		}else{

    		}
    	}
    	return view('users.login_register');
    }


    /*function for check email*/
    public function check_email(Request $request){
    	$data = $request->all();
    	$usersCount = User::where('email',$data['email'])->count();
    	if($usersCount > 0){
    			echo  "false";
    		}else{
    			echo "true"; die();
    	}
    }
}
