<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Country;
use Auth;
use Session;

class UsersController extends Controller
{
	 /*function for user register or login page*/
	public function userLoginRegister(){
		return view('users.login_register');
	}

    /*function for register page*/
    public function register(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		// echo "<pre>";die(print_r($data));
    		//check user already exists
    		$usersCount = User::where('email',$data['email'])->count();
    		if($usersCount > 0){
    			return redirect()->back()->with('flash_message_error','Email already exists');
    		}else{
    			$user = new User;
    			$user->name = $data['name'];
    			$user->email = $data['email'];
    			$user->password = bcrypt($data['password']);
    			$user->save();
    			if (Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])) {
    				Session::put('frontSession',$data['email']);
    				return redirect('/cart/view_cart');
    			}
    		}
    	}
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

    /*user log out*/
    public function userLogout(){
    	Auth::logout();
    	Session::forget('frontSession');
    	return redirect('/');
    }


    /*user login function*/
    public function userLogin(Request $request){
    	if($request->isMethod('post')){
    		$data = $request->all();
    		if(Auth::attempt(['email'=>$data['email'],'password'=>$data['password']])){
    			Session::put('frontSession',$data['email']);
    			return redirect('/cart/view_cart');
    		}else{
    			return redirect()->back()->with('flash_message_login_error','Please enter valid E-mail or Password');
    		}
    	}
    }

    /*user account function*/
    public function userAccount(){
    	$user_id = Auth::user()->id;
    	$userDetails = User::find($user_id);
    	$countries = Country::get();
    	return view('users.account')->with(compact('countries','userDetails'));
    }
}
