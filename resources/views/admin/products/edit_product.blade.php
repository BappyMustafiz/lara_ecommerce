@extends('layouts.adminLayout.admin_design')
@section('content')
  <div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Products</a> <a href="#" class="current">Edit Product</a> </div>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Product</h5>
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
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/edit_product/'.$product_details->id)}}" name="edit_product" id="edit_product" novalidate="novalidate">
            @csrf
              <div class="control-group">
                <label class="control-label">Product Under Category</label>
                <div class="controls">
                  <select name="category_id" id="category_id" style="width: 220px;">
                    <?= $categories_dropdown;?>
                  </select>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Product Name</label>
                <div class="controls">
                  <input type="text" name="product_name" id="product_name" value="{{ $product_details->product_name }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Product Code</label>
                <div class="controls">
                  <input type="text" name="product_code" id="product_code" value="{{ $product_details->product_name }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Product Color</label>
                <div class="controls">
                  <input type="text" name="product_color" id="product_color" value="{{ $product_details->product_color }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Product Description</label>
                <div class="controls">
                  <textarea type="text" name="product_description" id="product_description">{{ $product_details->product_description }}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Product Price</label>
                <div class="controls">
                  <input type="text" name="price" id="price" value="{{ $product_details->price }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Product Image</label>
                  <div class="controls">
                    <input type="file" name="image" id="image" />
                    <input type="hidden" name="current_image" value="{{ $product_details->image }}" id="image" />
                    @if(!empty($product_details->image))
                      <img style="width: 50px;" src="{{ asset('/images/backend_images/products/small/'.$product_details->image) }}" alt="product-image"> | <a href="{{url('/admin/delete_product_image/'.$product_details->id )}}">Delete</a>
                    @endif  
                  </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Update Product" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection