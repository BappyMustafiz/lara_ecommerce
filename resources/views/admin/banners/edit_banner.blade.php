@extends('layouts.adminLayout.admin_design')
@section('content')
<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Sliders</a> <a href="#" class="current">Edit Slider</a> </div>
  </div>
  <div class="container-fluid"><hr>
    <div class="row-fluid">
      <div class="span12">
        <div class="widget-box">
          <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
            <h5>Edit Slider</h5>
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
            <form enctype="multipart/form-data" class="form-horizontal" method="post" action="{{url('/admin/edit_banner/'.$banner_details->id)}}" name="edit_banner" id="edit_banner" novalidate="novalidate">
            @csrf
              <div class="control-group">
                <label class="control-label">Slider title</label>
                <div class="controls">
                  <input type="text" name="title" id="title" value="{{ $banner_details->title }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Slider sub-title</label>
                <div class="controls">
                  <input type="text" name="subtitle" id="subtitle" value="{{ $banner_details->subtitle }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Slider description</label>
                <div class="controls">
                  <textarea type="text" name="description" id="description">{{ $banner_details->description }}</textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Slider link</label>
                <div class="controls">
                  <input type="text" name="link" id="link" value="{{ $banner_details->link }}">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label">Slider Image</label>
                  <div class="controls">
                    <input type="file" name="image" id="image" />
                    <input type="hidden" name="current_image" value="{{ $banner_details->image }}" id="image" />
                    @if(!empty($banner_details->image))
                      <img style="width: 50px;" src="{{ asset('/images/frontend_images/banners/'.$banner_details->image) }}" alt="slider-image"> | <a href="{{url('/admin/delete_banner_image/'.$banner_details->id )}}">Delete</a>
                    @endif  
                  </div>
              </div>
              <div class="control-group">
                <label class="control-label">Enable</label>
                <div class="controls">
                  <input type="checkbox" name="status" id="status" @if($banner_details->status=="1") checked @endif value="1">
                </div>
              </div>
              <div class="form-actions">
                <input type="submit" value="Update Slider" class="btn btn-success">
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection