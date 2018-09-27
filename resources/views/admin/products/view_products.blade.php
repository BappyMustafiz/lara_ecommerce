@extends('layouts.adminLayout.admin_design')
@section('content')

	<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">View Products</a> </div>
  </div>
  <div class="container-fluid">
    <hr>
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
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
            <h5>View Products</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Product Id</th>
                  <th>Category Id</th>
                  <th>Category Name</th>
                  <th>Product Name</th>
                  <th>Product Code</th>
                  <th>Product Color</th>
                  <th>Product Price</th>
                  <th>Product Image</th>
                  <th>Product status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
				@foreach($products as $product)
                <tr class="gradeX">
                  <td>{{$product->id}}</td>
                  <td>{{$product->category_id}}</td>
                  <td>{{$product->category_name}}</td>
                  <td>{{$product->product_name}}</td>
                  <td>{{$product->product_code}}</td>
                  <td>{{$product->product_color}}</td>
                  <td>{{$product->price}}</td>
                  <td>
                      @if(!empty($product->image))
                      <img src="{{asset('/images/backend_images/products/small/'.$product->image)}}" alt="" style="width: 60px;">
                      @endif
                  </td>
                  <td>{{$product->status=="1" ? 'active' : 'deactive' }}</td>
                  <td class="center">
                    <a href="#myModal{{$product->id}}" data-toggle="modal" class="btn btn-success btn-mini" title="View Product">View</a>
                    <a href="{{url('/admin/edit_product/'.$product->id)}}" class="btn btn-primary btn-mini" title="Edit Product">Edit</a>
                    <a href="{{url('/admin/add_attributes/'.$product->id)}}" class="btn btn-success btn-mini" title="Add Attributes">Add Attributes</a>
                    <a href="{{url('/admin/add_alternate_images/'.$product->id)}}" class="btn btn-info btn-mini" title="Add Alternate Image">Alternate Image(s)</a>
                    <a rel="{{$product->id}}" rel1="delete_product" <?php /*href="{{url('/admin/delete_product/'.$product->id)}}"*/?> href="javascript:" class="btn btn-danger btn-mini deleteRecord" title="Delete Product">Delete</a>
                  </td>
                </tr>
                <!-- view product modal -->
                <div id="myModal{{$product->id}}" class="modal hide">
                  <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h3>{{$product->product_name}} Full details</h3>
                  </div>
                  <div class="modal-body">
                    <p>Product ID : {{$product->id}}</p>
                    <p>Category ID : {{$product->category_id}}</p>
                    <p>Product Category Name : {{$product->category_name}}</p>
                    <p>Product Name : {{$product->product_name}}</p>
                    <p>Product Code : {{$product->product_code}}</p>
                    <p>Product Color : {{$product->product_color}}</p>
                    <p>Product Price : {{$product->price}}</p>
                    <p>Product Description : {{$product->product_description}}</p>
                    <p>Product Description : {{$product->care}}</p>
                  </div>
                </div>
                <!-- view product modal -->
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