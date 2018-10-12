@extends('layouts.adminLayout.admin_design')
@section('content')

	<div id="content">
  <div id="content-header">
    <div id="breadcrumb"> <a href="index.html" title="Go to Home" class="tip-bottom"><i class="icon-home"></i> Home</a> <a href="#">Sliders</a> <a href="#" class="current">View sliders</a> </div>
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
            <h5>View sliders</h5>
          </div>
          <div class="widget-content nopadding">
            <table class="table table-bordered data-table">
              <thead>
                <tr>
                  <th>Slider Id</th>
                  <th>Slider title</th>
                  <th>Slider subtitle</th>
                  <th>Slider desc</th>
                  <th>Slider link</th>
                  <th>Slider Image</th>
                  <th>Slider status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
				@foreach($banners as $banner)
                <tr class="gradeX">
                  <td>{{$banner->id}}</td>
                  <td>{{$banner->title}}</td>
                  <td>{{$banner->subtitle}}</td>
                  <td>{{$banner->description}}</td>
                  <td>{{$banner->link}}</td>
                  <td>
                      @if(!empty($banner->image))
                      <img src="{{asset('/images/frontend_images/banners/'.$banner->image)}}" alt="" style="width: 60px;">
                      @endif
                  </td>
                  <td>{{$banner->status=="1" ? 'Active' : 'Inactive' }}</td>
                  <td class="center">
                    <a href="{{url('/admin/edit_banner/'.$banner->id)}}" class="btn btn-primary btn-mini" title="Edit Slider">Edit</a>
                    <a rel="{{$banner->id}}" rel1="delete_banner" <?php /*href="{{url('/admin/delete_product/'.$product->id)}}"*/?> href="javascript:" class="btn btn-danger btn-mini deleteRecord" title="Delete Slider">Delete</a>
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