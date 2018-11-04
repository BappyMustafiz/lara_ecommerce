@extends('layouts.frontLayout.front_design')
@section('content')
	<section id="form" style="margin-top: 20px; margin-bottom: 40px;"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form"><!--login form-->
						<h2>Login to your account</h2>
						<form action="#">
							<input type="text" placeholder="Name" />
							<input type="email" placeholder="Email Address" />
							<span>
								<input type="checkbox" class="checkbox"> 
								Keep me signed in
							</span>
							<button type="submit" class="btn btn-default">Login</button>
						</form>
					</div><!--/login form-->
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form"><!--sign up form-->
						<h2>New User Signup!</h2>
						@if(Session::has('flash_message_error'))
			            <div class="alert alert-error alert-block" style="color: red; background: #d4a28b;">
			                <button type="button" class="close" data-dismiss="alert">x</button>
			                <strong>{!! session('flash_message_error')!!}</strong>
			            </div>
			            @endif
			            @if(Session::has('flash_message_success'))
			                <div class="alert alert-success alert-block">
			                    <button type="button" class="close" data-dismiss="alert">x</button>
			                    <strong>{!! session('flash_message_success')!!}</strong>
			                </div>
			            @endif
						<form id="registerForm" name="registerForm" action="{{url('/login-register')}}" method="post">
							@csrf
							<input id="name" name="name" type="text" placeholder="Name"/>
							<input id="email" name="email" type="email" placeholder="Email Address"/>
							<input id="password" name="password" type="password" placeholder="Password"/>
							<button type="submit" class="btn btn-default">Signup</button>
						</form>
					</div><!--/sign up form-->
				</div>
			</div>
		</div>
	</section><!--/form-->
@endsection