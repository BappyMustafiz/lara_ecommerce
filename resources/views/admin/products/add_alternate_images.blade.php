@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  	<div id="content-header">
    	<div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a><a href="#" class="current">Add Alternate images</a> </div>
  	</div>
  	<div class="container-fluid"><hr>
		<div class="row-fluid">
		  	<div class="span12">
		    	<div class="widget-box">
			        <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
			        	<h5>Add Alternate images</h5>
			        </div>
			        <div class="widget-content nopadding">
				      	@if(Session::has('flash_message_error'))
				        <div class="alert alert-error alert-block">
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
			    		<form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/add_alternate_images/'.$product_details['id'])}}" 
			    		      name="add_attributes" id="add_attributes">
			        	    @csrf
			        	    <input type="hidden" name="product_id" value="{{$product_details['id']}}">
					        <div class="control-group">
					            <label class="control-label">Product Name</label>
					            <label class="control-label"><strong>{{$product_details['product_name']}}</strong></label>
					        </div>
				            <div class="control-group">
					            <label class="control-label">Product Code</label>
					            <label class="control-label"><strong>{{$product_details['product_code']}}</strong></label>
				            </div>
				            <div class="control-group">
				                <label class="control-label">Alternate Image(s)</label>
				                <div class="controls">
				                    <input type="file" name="image[]" id="image" multiple="multiple" />
				                </div>
				             </div>
					        <div class="form-actions">
					            <input type="submit" value="Add Images" class="btn btn-success">
					        </div>
			            </form>
		            </div>
		        </div>
		    </div>
		</div>
		<!-- attributes -->
		<div class="row-fluid">
	      <div class="span12">
	        <div class="widget-box">
	          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
	            <h5>View alternate images</h5>
	          </div>
	          <div class="widget-content nopadding">
	            <table class="table table-bordered data-table">
	              <thead>
	                <tr>
	                  <th>Image id</th>
	                  <th>Product id</th>
	                  <th>Image</th>
	                  <th>Action</th>
	                </tr>
	              </thead>
	              <tbody>
					@foreach($productsImages as $image)
						<tr>
							<td>{{$image->id}}</td>
							<td>{{$image->product_id}}</td>
							<td><img style="width: 50px; height: 50px;" src="{{asset('images/backend_images/products/small/'.$image->image)}}"></td>
							<td class="center">
								<a href="{{url('/admin/delete_alternate_image/'.$image->id)}}" id="deleteAltImg"  class="btn btn-danger btn-mini">Delete</a>
							</td>
						</tr>
					@endforeach	
	              </tbody>
	            </table>
	          </div>
	        </div>
	      </div>
	    </div>
    </div>
</div>
@endsection