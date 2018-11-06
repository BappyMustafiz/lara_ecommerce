@extends('layouts.frontLayout.front_design')
@section('content')
	<section id="form" style="margin-top: 20px; margin-bottom: 40px;"><!--form-->
		<div class="container">
			<div class="row">
				<div class="col-sm-4 col-sm-offset-1">
					<div class="login-form">
						<h2>Update Acccount</h2>
						@if(Session::has('flash_message_accupdate_error'))
			            <div class="alert alert-error alert-block" style="color: red; background: #d4a28b;">
			                <button type="button" class="close" data-dismiss="alert">x</button>
			                <strong>{!! session('flash_message_accupdate_error')!!}</strong>
			            </div>
			            @endif
			            @if(Session::has('flash_message_success'))
			                <div class="alert alert-success alert-block">
			                    <button type="button" class="close" data-dismiss="alert">x</button>
			                    <strong>{!! session('flash_message_success')!!}</strong>
			                </div>
			            @endif
						<form id="accountForm" name="accountForm" action="{{url('/account')}}" method="post">
							@csrf
							<input type="text" id="name" name="name" value="{{$userDetails->name}}" />
							<input type="text" id="address" name="address" placeholder="Address" />
							<input type="text" id="city" name="city" placeholder="City" />
							<input type="text" id="state" name="state" placeholder="State" />
							<select name="country" id="country">
								<option value="">Select country</option>
								@foreach($countries as $country)
									<option value="{{$country->country_name}}">{{$country->country_name}}</option>
								@endforeach
							</select>
							<input style="margin-top: 10px;" type="text" id="pincode" name="pincode" placeholder="Pincode" />
							<input type="text" id="mobile" name="mobile" placeholder="Mobile" />
							<button type="submit" class="btn btn-default">Update</button>
						</form>
					</div>
				</div>
				<div class="col-sm-1">
					<h2 class="or">OR</h2>
				</div>
				<div class="col-sm-4">
					<div class="signup-form">
						<h2>Update Password</h2>

					</div>
				</div>
			</div>
		</div>
	</section>
@endsection